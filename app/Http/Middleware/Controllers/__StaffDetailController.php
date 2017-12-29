<?php

namespace App\Http\Controllers;

use App\Model\DailyInput;
use App\Model\Designation;
use App\Model\StaffDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $staffDetail = ['name'=>$request->input('inputName'),
            'email'=>$request->input('inputEmail'),
            'password'=>$request->input('inputPassword'),
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
        //$staffDetaildb->password =$request->input('inputPassword');
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
}
