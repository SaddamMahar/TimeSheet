<?php
namespace App\Http\Controllers;
use App\Model\DailyInput;
use App\Model\StaffDetail;
use App\Model\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
class DailyInputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->active == '0'){
            Auth::logout();
            return redirect('login');
        }
        if(Auth::user()->role->role == 'admin')
        {
            $dailyInputs = DailyInput::all();
            return View('dailyInput/dailyInput')->with("dailyInputs",$dailyInputs)->with('staffDetails',StaffDetail::all())->with('clients',Client::all());
        }else{
            $dailyInputs = DailyInput::where('user_id','=',Auth::user()->id)->get();
            $stafflist[0] = StaffDetail::find(Auth::user()->id);
            return View('dailyInput/dailyInput')->with("dailyInputs",$dailyInputs)->with('staffDetails',$stafflist)->with('clients',Client::all());
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View("dailyInput/createDailyInput")->with('staffDetails',StaffDetail::all())->with('clients',Client::all());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = $request->input('inputStaffDetailID');
        if($user_id == null || $user_id == 0 ){
            $user_id = $request->input('inputStaffDetail');
        }
        $client_id = $request->input('inputClient');
        $timeFrom = $request->input('inputTimeFrom');
        $timeUpto = $request->input('inputTimeUpto');
        $reportDate = $request->input('inputReportDate');
        if($request->input('inputTimeTotal') == null){
            $timeTotal = date('H:i:s', strtotime($request->input('inputTimeUpto')) - strtotime($request->input('inputTimeFrom')));
        }else{
            $timeTotal = $request->input('inputTimeTotal');
            if(strpos($timeTotal,':') === false  ){//&& is_numeric($timeTotal)
                $timeTotal = $timeTotal.':00' ;
            }
        }
        $dailyInput = ['user_id'=>$user_id,
            'client_id'=>$client_id,
            'timeFrom'=>$timeFrom,
            'timeUpto'=>$timeUpto,
            'reportDate'=>$reportDate,
            'timeTotal'=>$timeTotal
        ];
        DailyInput::InsertGetID($dailyInput);
        return redirect('/dailyInput');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Model\DailyInput  $dailyInput
     * @return \Illuminate\Http\Response
     */
    public function show(DailyInput $dailyInput)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\DailyInput  $dailyInput
     * @return \Illuminate\Http\Response
     */
    public function edit($dailyInput)
    {
//        return View("dailyInput/dailyInputEdit")->with('dailyInput',$dailyInput)
//            ->with('staffDetails',StaffDetail::all())->with('clients',Client::all());
        $data = DailyInput::find($dailyInput);
        echo json_encode($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\DailyInput  $dailyInput
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyInput $dailyInput)
    {
        $dailyInput = DailyInput::find($request->input('id'));
        $dailyInput->user_id = $request->input('inputStaffDetail');
        $dailyInput->client_id = $request->input('inputClient');
        $dailyInput->timeFrom = $request->input('inputTimeFrom');
        $dailyInput->timeUpto = $request->input('inputTimeUpto');
        $dailyInput->reportDate = $request->input('inputReportDate');
        $dailyInput->timeTotal =date('H:i:s', strtotime($request->input('inputTimeUpto')) - strtotime($request->input('inputTimeFrom')));
        $dailyInput->save();
        return redirect('/dailyInput');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\DailyInput  $dailyInput
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyInput $dailyInput)
    {
        $dailyInput->delete();
        return redirect('/dailyInput');
    }
    public function delete($id)
    {
        $dailyInput = DailyInput::find($id);
        DailyInput::destroy($dailyInput->id);
        return redirect('/dailyInput');
    }
    public function updateDailyInput(Request $request)
    {
        $inputStaffDet = StaffDetail::find($request->input('inputStaffDetail'));
        $client = Client::find($request->input('inputClient'));
        $dailyInput = DailyInput::find($request->input('id'));
        $dailyInput->user_id = $inputStaffDet->id;
        $dailyInput->client_id = $client->id;
        $dailyInput->timeFrom = $request->input('inputTimeFrom');
        $dailyInput->timeUpto = $request->input('inputTimeUpto');
        $dailyInput->reportDate = $request->input('inputReportDate');
        if($request->input('inputTimeTotal') != null){
            $dailyInput->timeTotal =$request->input('inputTimeTotal');
        }else if($request->input('inputTimeUpto') != null && $request->input('inputTimeFrom') != null){
            $dailyInput->timeTotal =date('H:i:s', strtotime($request->input('inputTimeUpto')) - strtotime($request->input('inputTimeFrom')));
        }
        if(strpos($dailyInput->timeTotal,':') === false  ){
            $dailyInput->timeTotal = $dailyInput->timeTotal.':00' ;
        }
        $dailyInput->save();
        return redirect('/dailyInput');
    }
    public function getData(Request $request){
//        getting all inputs
        $dateFrom = $request->input('from');
        $dateUpto = $request->input('upto');
        $staffDetail = $request->input('inputStaffDetail');
        $client = $request->input('inputClient');

        $client = Client::find($client);
        $staffDetail = StaffDetail::find($staffDetail);
//        if both dates are present in input
        if($dateFrom != null && $dateUpto != null){
            //if login is not admin then
            if(Auth::user()->role->id != 1)
                $dailyInputs =DailyInput::where('reportDate', '>=', $dateFrom)->where('reportDate', '<=', $dateUpto)->get()->where('user_id',Auth::user()->id);
            else
                $dailyInputs = DailyInput::where('reportDate', '>=', $dateFrom)->where('reportDate', '<=', $dateUpto)->get();
            $clients = [];
            $staffDetails = [];
            foreach($dailyInputs as $dailyInput){
                $clients[$dailyInput->client->id] = $dailyInput->client;
                $staffDetails[$dailyInput->user->id] = $dailyInput->user;
            }
//            all clients
            $clients = array_values($clients);
            $clients = collect($clients);
//            all staff
            $staffDetails = array_values($staffDetails);
            $staffDetails = collect($staffDetails);
//            if clients is present in input
            if(!empty($client)){
                $dailyInputs = $dailyInputs->where('client_id',$client->id);
                $staffDetails = null;
//                all staff
                foreach($dailyInputs as $dailyInput){
                    $staffDetails[$dailyInput->user->id] = $dailyInput->user;
                }
                $staffDetails = array_values($staffDetails);
                $staffDetails = collect($staffDetails);

            }
            if(!empty($staffDetail)){
                $dailyInputs = $dailyInputs->where('user_id',$staffDetail->id);
            }

            return View('dailyInput/dailyInput')->with("clients",$clients)->with('from',$dateFrom)->with('upto',$dateUpto)
                ->with('staffDetails',$staffDetails)->with('dailyInputs',$dailyInputs)->with('client',$client)->with('staffDetail',$staffDetail);
        }elseif(!empty($dateFrom) && $dateUpto == null) {
//            if one date is present in input
            $dailyInputs = DailyInput::where('reportDate','=',$dateFrom)->get();
            $clients = [];
            $staffDetails = [];
            foreach($dailyInputs as $dailyInput){
                $staffDetails[$dailyInput->user->id] = $dailyInput->user;
                $clients[$dailyInput->client->id] = $dailyInput->client;
            }
            $clients = array_values($clients);
            $clients = collect($clients);

            $staffDetails = array_values($staffDetails);
            $staffDetails = collect($staffDetails);

            if(!empty($client)){
                $staffDetails = null;
                $dailyInputs = $dailyInputs->where('client_id',$client->id);

                foreach($dailyInputs as $dailyInput){
                    $staffDetails[$dailyInput->user->id] = $dailyInput->user;
                }
                $staffDetails = array_values($staffDetails);
                $staffDetails = collect($staffDetails);
            }
            if(!empty($staffDetail)){
                $dailyInputs = $dailyInputs->where('user_id',$staffDetail->id);
            }

            return View('dailyInput/dailyInput')->with("clients",$clients)->with('client',$client)->with('client',$client)->with('staffDetail',$staffDetail)
                ->with('staffDetails',$staffDetails)->with('dailyInputs',$dailyInputs)->with('from',$dateFrom);
        }elseif(!empty($client)) {
            if(Auth::user()->role->id != 1)
                $dailyInputs =DailyInput::where('client_id', $client->id)->where('user_id', Auth::user()->id)->get();
            else
                $dailyInputs =DailyInput::where('client_id', $client->id)->get();
            $staffDetails = [];
            foreach($dailyInputs as $dailyInput){
                $staffDetails[$dailyInput->user->id] = $dailyInput->user;
            }
            $staffDetails = array_values($staffDetails);
            $staffDetails = collect($staffDetails);
            $clients = Client::all();
            $clients = $clients->where('client_id','!=',$client->id);

            if(!empty($staffDetail)){
                $dailyInputs = $dailyInputs->where('user_id',$staffDetail->id);
            }
            return View('dailyInput/dailyInput')->with("clients",$clients)
                ->with('staffDetails',$staffDetails)->with('dailyInputs',$dailyInputs)
                ->with('client',$client)->with('staffDetail',$staffDetail);
        }elseif(!empty($staffDetail)) {
            $dailyInputs = DailyInput::where('user_id','=',$staffDetail->id)->get();
            return View('dailyInput/dailyInput')->with("clients",Client::all())
                ->with('staffDetails',StaffDetail::all())->with('dailyInputs',$dailyInputs)->with('staffDetail',$staffDetail);
        }
        if(Auth::user()->role->id != 1)
        {
            return View('dailyInput/dailyInput')->with("clients",Client::all())
                ->with('staffDetails',StaffDetail::find(Auth::user()->id))->with('dailyInputs',DailyInput::all());
        }
        return View('dailyInput/dailyInput')->with("clients",Client::all())
            ->with('staffDetails',StaffDetail::all())->with('dailyInputs',DailyInput::all());
    }
    public function storeRecord(Request $request)
    {
        $user_id = $request->input('inputStaffDetailID');
        if($user_id == null || $user_id == 0 ){
            $user_id = $request->input('inputStaffDetail');
        }
        $client_id = $request->input('inputClient');
        $timeFrom = $request->input('inputTimeFrom');
        $timeUpto = $request->input('inputTimeUpto');
        $reportDate = $request->input('inputReportDate');
        if($request->input('inputTimeTotal') == null){
            $timeTotal = date('H:i:s', strtotime($request->input('inputTimeUpto')) - strtotime($request->input('inputTimeFrom')));
        }else{
            $timeTotal = $request->input('inputTimeTotal');
            if(strpos($timeTotal,':') === false  ){//&& is_numeric($timeTotal)
                $timeTotal = $timeTotal.':00' ;
            }
        }
        $dailyInput = ['user_id'=>$user_id,
            'client_id'=>$client_id,
            'timeFrom'=>$timeFrom,
            'timeUpto'=>$timeUpto,
            'reportDate'=>$reportDate,
            'timeTotal'=>$timeTotal
        ];
        DailyInput::InsertGetID($dailyInput);
        return redirect('/dailyInput');
    }
    
    public function resetPassword(Request $request)
    {
        $oldPassword = $request->input('inputPassword');
        $nPassword = $request->input('inputNewPassword');
        $confirmldPassword = $request->input('inputNewConfirmPassword');
        if(!Hash::check($oldPassword, Auth::user()->getAuthPassword())){
        }else{
            if($nPassword == $confirmldPassword)
            {
                $user = Auth::user();
                $user->password = Hash::make($nPassword);
                $user->save();
            }
        }
	return Redirect::back();
    }
}