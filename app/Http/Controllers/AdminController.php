<?php

namespace App\Http\Controllers;

use App\Model\Charge;
use App\Model\Client;
use App\Model\DailyInput;
use App\Model\Designation;
use App\Model\StaffDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{

//    public function __construct(){
//        $this->middleware('auth:admin');
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return View('admin/admin')->with("clients",Client::all())
            ->with('staffDetails',StaffDetail::all())->with('clientsAll','')->with('staffDetailsAll','');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designations = Designation::all();
        return View("charge/createCharge")->with('designations',$designations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $charge = ['rate'=>$request->input('inputRate'),
            'upto'=>$request->input('inputUpto'),
            'designation_id'=>$request->input('inputDesignation')];

        Charge::InsertGetID($charge);
        return redirect('/charge');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Charge  $charge
     * @return \Illuminate\Http\Response
     */
    public function show(Charge $charge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Charge  $charge
     * @return \Illuminate\Http\Response
     */
    public function edit(Charge $charge)
    {
        return View("charge/chargeEdit")->with('charge',$charge)->with('designations',Designation::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Charge  $charge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $chargedb = Charge::find($request->input('id'));
        $chargedb->rate = $request->input('inputRate');
        $chargedb->upto =$request->input('inputUpto');
        $chargedb->designation_id =$request->input('inputDesignation');
        $chargedb->save();
        return redirect('/charge');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Charge  $charge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Charge $charge)
    {
        $charge->delete();
        return redirect('/charge');
    }

    public function ajaxCall(Request $request)
    {

        //echo 'ajaxCall';
        $staffID = Input::get('staffID');
        $clientID = Input::get('clientID');
        $dateInput = Input::get('datepicked');
        if ($clientID != null) {
            $client = Client::find($clientID);
            $dailyInputs = $client->dailyInput;

            $staffDetail = [];
            foreach ($dailyInputs as $dailyInput) {
                $staffDetail[] = array('staff_id' => $dailyInput->staffDetail->id, 'staff_name' => $dailyInput->staffDetail->name, 'designation_id' => $dailyInput->staffDetail->designation_id, 'rate' => $dailyInput->staffDetail->designation->charge->last()->rate);
            }
            return json_encode($staffDetail);
        } elseif ($staffID != null) {
            $staffDetail = StaffDetail::find($staffID);
            $dailyInput = $staffDetail->dailyInput->last();
            return $dailyInput;
        } elseif ($dateInput != null) {
            $dailyInput = DailyInput::where('reportDate', $dateInput)->get();

            $clients = [];
            foreach ($dailyInput as $dailyInput) {
                $clients[] = array('client_id' => $dailyInput->client->id, 'client_name' => $dailyInput->client->name);
            }
            return json_encode($clients);
        }
    }

    public function getData(Request $request){

//        getting all parameters
        $dateFrom = $request->input('from');
        $dateUpto = $request->input('upto');
        $staffDetail = $request->input('inputStaffDetail');
        $client = $request->input('inputClient');
//        if both dates are present in input
        if($dateFrom != null && $dateUpto != null)
        {
            $dailyInputs = DailyInput::where('reportDate', '>=', $dateFrom)->where('reportDate', '<=', $dateUpto)->get();
            $clients = [];
            $staffDetails = [];

            foreach($dailyInputs as $dailyInput){
                $clients[$dailyInput->client->id] = $dailyInput->client;
            }
//            all clients
            $clients = array_values($clients);
            $clients = collect($clients);

//            if clients is present in input
            if(!empty($client)){
                $client = Client::find($client);
                $dailyInputsColl = [];
                foreach($dailyInputs as $dailyInput){
                    if($dailyInput->client->id == $client->id){
                        $dailyInputsColl[$dailyInput->id] = $dailyInput;
                    }
                }
                $dailyInputsColl = array_values($dailyInputsColl);
                $dailyInputs = collect($dailyInputsColl);
//                all staff
                foreach($dailyInputs as $dailyInput){
                    $staffDetails[$dailyInput->staffDetail->id] = $dailyInput->staffDetail;
                }
                $staffDetails = array_values($staffDetails);
                $staffDetails = collect($staffDetails);
//                if staff is present in input
                if(!empty($staffDetail)){
                    $dailyInputsColl = [];
                    foreach($dailyInputs as $dailyInput){
                        if($dailyInput->staffDetail->id == $staffDetail){
                            $dailyInputsColl[$dailyInput->id] = $dailyInput;
                        }
                    }
                    $dailyInputsColl = array_values($dailyInputsColl);
                    $dailyInputs = collect($dailyInputsColl);
                    return View('admin/admin')->with("clients",$clients)->with('from',$dateFrom)->with('upto',$dateUpto)
                        ->with('staffDetails',$staffDetails)->with('dailyInputs',$dailyInputs)->with('client',$client);
                }
                return View('admin/admin')->with("clients",$clients)->with('from',$dateFrom)->with('upto',$dateUpto)
                    ->with('staffDetails',$staffDetails)->with('dailyInputs',$dailyInputs)->with('client',$client);
            }

            foreach($dailyInputs as $dailyInput){
                $staffDetails[$dailyInput->staffDetail->id] = $dailyInput->staffDetail;
            }
            $staffDetails = array_values($staffDetails);
            $staffDetails = collect($staffDetails);

            return View('admin/admin')->with("clients",$clients)->with('from',$dateFrom)->with('upto',$dateUpto)
                ->with('staffDetails',$staffDetails)->with('dailyInputs',$dailyInputs);

        }elseif(!empty($dateFrom) && $dateUpto == null) {
//            if one date is present in input
            $dailyInputs = DailyInput::where('reportDate','=',$dateFrom)->get();

            $clients = [];
            $staffDetails = [];
            if(!empty($client)){
                $client = Client::find($client);
                $staffDetails = [];
                $dailyInputss = $client->dailyInput;
                $dailyInputnew = [];
                foreach($dailyInputss as $dailyInput){
                    foreach($dailyInputs as $dailyInputn){
                        if($dailyInputn->id == $dailyInput->id){
                            $dailyInputnew[$dailyInputn->id] = $dailyInputn;
                        }
                    }
                }
                $dailyInputnew = array_values($dailyInputnew);
                $dailyInputs = collect($dailyInputnew);
                if(!empty($staffDetail)){
                    $dailyInputsCommon = [];
                    foreach ($dailyInputs as $dailyInput) {
                        if($dailyInput->staffDetail->id == $staffDetail){
                            $dailyInputsCommon[$dailyInput->id] = $dailyInput;
                        }
                    }
                    $dailyInputsCommon = array_values($dailyInputsCommon);
                    $dailyInputs = collect($dailyInputsCommon);
                    foreach($dailyInputs as $dailyInput){
                        $staffDetails[$dailyInput->staffDetail->id] = $dailyInput->staffDetail;
                    }
                    $staffDetails = array_values($staffDetails);
                    $staffDetails = collect($staffDetails);
                    return View('admin/admin')->with("clients",$clients)
                        ->with('staffDetails',$staffDetails)->with('dailyInputs',$dailyInputs)
                        ->with('from',$dateFrom)->with('client',$client)->with('staffDetail',StaffDetail::find($staffDetail));
                }
                foreach($dailyInputs as $dailyInput){
                    $staffDetails[$dailyInput->staffDetail->id] = $dailyInput->staffDetail;
                }
                $staffDetails = array_values($staffDetails);
                $staffDetails = collect($staffDetails);
                return View('admin/admin')->with("clients",$clients)
                    ->with('staffDetails',$staffDetails)->with('dailyInputs',$dailyInputs)
                    ->with('from',$dateFrom)->with('client',$client);
            }


            foreach($dailyInputs as $dailyInput){
                $clients[$dailyInput->client->id] = $dailyInput->client;
                $staffDetails[$dailyInput->staffDetail->id] = $dailyInput->staffDetail;
            }
            $clients = array_values($clients);
            $clients = collect($clients);

            $staffDetails = array_values($staffDetails);
            $staffDetails = collect($staffDetails);

            return View('admin/admin')->with("clients",$clients)
                ->with('staffDetails',$staffDetails)->with('dailyInputs',$dailyInputs)->with('from',$dateFrom);

        }elseif($client != '0' && $client != null) {
            $client = Client::find($client);
            $dailyInputs = $client->dailyInput;
            $staffDetails = [];

            foreach($dailyInputs as $dailyInput){
                $staffDetails[$dailyInput->staffDetail->id] = $dailyInput->staffDetail;
            }
            $staffDetails = array_values($staffDetails);
            $staffDetails = collect($staffDetails);
            $clients = Client::all();
            $clientsColl = [];
            foreach($clients as $clientobj){
                if($clientobj->id != $client->id){
                    $clientsColl[$clientobj->id] = $clientobj;
                }
            }
            $clientsColl = array_values($clientsColl);
            $clients = collect($clientsColl);

            if(!empty($staffDetail)){
                $dailyInputsCommon = [];
                foreach ($dailyInputs as $dailyInput) {
                    if($dailyInput->staffDetail->id == $staffDetail){
                        $dailyInputsCommon[$dailyInput->id] = $dailyInput;
                    }
                }
                $dailyInputsCommon = array_values($dailyInputsCommon);
                $dailyInputs = collect($dailyInputsCommon);
                $staffDetails = [];
                foreach($dailyInputs as $dailyInput){
                    if($dailyInput->staffDetail->id != $staffDetail){
                        $staffDetails[$dailyInput->staffDetail->id] = $dailyInput->staffDetail;
                    }
                }
                $staffDetails = array_values($staffDetails);
                $staffDetails = collect($staffDetails);

                return View('admin/admin')->with("clients",$clients)
                    ->with('staffDetails',$staffDetails)->with('dailyInputs',$dailyInputs)
                    ->with('client',$client)->with('staffDetail',StaffDetail::find($staffDetail));
            }

            return View('admin/admin')->with("clients",$clients)
                ->with('staffDetails',$staffDetails)->with('dailyInputs',$dailyInputs)
                ->with('client',$client);

        }elseif($client != '0' && $client != null) {
            $dailyInputs = DailyInput::where('client_id','=',$client)->get();
        }elseif($staffDetail != '0' && $staffDetail != null) {
            $dailyInputs = DailyInput::where('user_id','=',$staffDetail)->get();
            return View('admin/admin')->with("clients",Client::all())
                ->with('staffDetails',StaffDetail::all())->with('dailyInputs',$dailyInputs)->with('staffDetail',StaffDetail::find($staffDetail));
        }

        $dail = DailyInput::all();
        return View('admin/admin')->with("clients",Client::all())
            ->with('staffDetails',StaffDetail::all())->with('dailyInputs',$dail);
    }
}
