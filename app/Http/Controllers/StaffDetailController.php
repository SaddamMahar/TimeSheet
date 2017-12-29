<?php

namespace App\Http\Controllers;

use App\Model\DailyInput;
use App\Model\Designation;
use App\Model\StaffDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class StaffDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffDetails = StaffDetail::all();
        $designations = Designation::all();

        return View('staffDetail/staffDetail')->with("staffDetails",$staffDetails)->with('designations',$designations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designations = Designation::all();

        return View("staffDetail/createStaffDetail")->with('designations',$designations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pass ='';
        if($request->input('inputPassword') != null)
        {
            $pass = $request->input('inputPassword');
        }
        $staffDetail = ['name'=>$request->input('inputName'),
            'email'=>$request->input('inputEmail'),

            'password'=>$pass,
            'designation_id'=>$request->input('inputDesignation'),
            'joiningDate'=>$request->input('inputJoiningDate'),
            'leavingDate'=>$request->input('inputLeavingDate')];

        StaffDetail::InsertGetID($staffDetail);
        return redirect('/login')->with('message','you cannot login until activated by admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StaffDetail  $staffDetail
     * @return \Illuminate\Http\Response
     */
    public function show(StaffDetail $staffDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StaffDetail  $staffDetail
     * @return \Illuminate\Http\Response
     */
    public function edit($staffDetail)
    {
//        return View("staffDetail/staffDetailEdit")->with('staffDetail',$staffDetail)->with('designations',Designation::all());
        $data = StaffDetail::find($staffDetail);

        echo json_encode($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaffDetail  $staffDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $staffDetaildb = StaffDetail::find($request->input('id'));
        $staffDetaildb->name = $request->input('inputName');
        $staffDetaildb->email =$request->input('inputEmail');
        $staffDetaildb->password =$request->input('inputPassword');
        $staffDetaildb->joiningDate =$request->input('inputJoiningDate');
        $staffDetaildb->leavingDate =$request->input('inputLeavingDate');
        $staffDetaildb->designation_id =$request->input('inputDesignation');
        $staffDetaildb->save();

        return redirect('/staffDetail');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaffDetail  $staffDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffDetail $staffDetail)
    {
        if($staffDetail->dailyInput == null){
            $staffDetail->delete();
        }else{
            $dailyInput = $staffDetail->dailyInput;
            foreach($dailyInput as $dailyInput){
                $dailyInput->delete();
            }
            $staffDetail->delete();
        }

        return redirect('/staffDetail');
    }

    public function delete($id)
    {

        $staffDetail = StaffDetail::find($id);
        $dailyInputs = DailyInput::where('user_id','=',$staffDetail)->get();
        foreach($dailyInputs as $dialyinput)
        {
            $dialyinput->delete();
        }
        StaffDetail::destroy($staffDetail->id);
        return redirect('/staffDetail');
    }

    /**
     * to update user edited in popup
     *
     * @param  \App\StaffDetail  $staffDetail
     * @return \Illuminate\Http\Response
     */
    public function updateStaffDetail(Request $request)
    {
        $staffDetaildb = StaffDetail::find($request->input('id'));
        $staffDetaildb->name = $request->input('inputName');
        $staffDetaildb->email =$request->input('inputEmail');
        if($request->input('inputPassword') != null)
            $staffDetaildb->password =Hash::make($request->input('inputPassword'));
        $staffDetaildb->joiningDate =$request->input('inputJoiningDate');
        $staffDetaildb->leavingDate =$request->input('inputLeavingDate');
        $staffDetaildb->designation_id =$request->input('inputDesignation');
        $staffDetaildb->save();
        return redirect('/staffDetail');
    }

    /**
     * to update user active column
     *
     * @param  \App\StaffDetail  $staffDetail
     * @return \Illuminate\Http\Response
     */
    public function updateStaffDetailActive($id)
    {
        $userdb = User::find($id);
        if($userdb->active == '0'){
            $userdb->active = '1';
        }else{
            $userdb->active = '0';
        }
        $userdb->save();
//        return redirect('/staffDetail');
    }

    public function allStaff(Request $request)
    {

        $columns = array(
            0 =>'name',
            1=> 'designation',
            2=> 'email',
            3=> 'joinningdate',
            4=> 'leavingdate',
        );

        $totalData = User::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if($request->input('search.value') == null || $request->input('search.value') == '')
        {
            $users = User::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $users =  User::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = User::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($users))
        {
            foreach ($users as $user)
            {
                $edit =  url("/user/".$user->id.'/edit/');
                $delete =  url("/staffDetail/delete/".$user->id);
                $editImg =  url("/img/edit.png");
                $delImg =  url("/img/remove.png");


                $nestedData['id'] = $user->id;
                $nestedData['name'] = $user->name;
                $nestedData['designation'] = isset($user->designation->title)?$user->designation->title:null;//substr(strip_tags($client->body),0,50)."...";
                $nestedData['email'] = isset($user->email)?$user->email:null;//date('j M Y h:i a',strtotime($client->created_at));
                if($user->active == 1){
                    $nestedData['active'] = '<input type = "checkbox" name = "toggle-one" id="toggle-one" onclick="updateActive(' .$user->id .')" checked = "checked">';

                }else{
                    $nestedData['active'] = '<input type = "checkbox" name = "toggle-one" id="toggle-one" onclick="updateActive(' .$user->id .')">';

                }
                $nestedData['joinningdate'] = isset($user->joiningDate)?$user->joiningDate:null;//date('j M Y h:i a',strtotime($client->created_at));
                $nestedData['leavingdate'] = isset($user->leavingdate)?$user->leavingdate:null;//date('j M Y h:i a',strtotime($client->created_at));
                $nestedData['action'] = "<ul class='list-inline'><li>
<a href='' data-toggle='modal' data-target='#myModal2' onclick='edit_book($user->id)' ><img src=".$editImg." alt=''></a>
</li><li><a href=".$delete."><img src=".$delImg." alt=''></a></li></ul>";


                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);

    }
}
