<?php

namespace App\Http\Controllers;

use App\Model\Charge;
use App\Model\DailyInput;
use App\Model\Designation;
use App\Model\StaffDetail;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designations = Designation::all();
        return View('designation/designation')->with("designations",$designations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View("designation/createDesignation");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $designation = ['title'=>$request->input('inputTitle')];
        Designation::InsertGetID($designation);
        return redirect('/designation');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit($designation)
    {
//        return View("designation/designationEdit")->with('designation',$designation);
        $data = Designation::find($designation);
        echo json_encode($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $designationdb = Designation::find($request->input('id'));
        $designationdb->title = $request->input('inputTitle');
        $designationdb->save();
        return redirect('/designation');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation)
    {
        dd('---');
        if($designation->staffDetail != null){
            $staffDetails = $designation->staffDetail;
            foreach($staffDetails as $staffDetail){
                if($staffDetail->dailyInput == null){
                    $s = $staffDetail->id;
                    $staffDetail->delete();
                }else{
                    $dailyInput = $staffDetail->dailyInput;
                    foreach($dailyInput as $dailyInput){
                        $s = $dailyInput->id;
                        $dailyInput->delete();
                    }
                    $s = $staffDetail->id;
                    $staffDetail->delete();
                }
            }
        }
        if($designation->charge != null){
            $charges = $designation->charge;
            foreach($charges as $charge){
                $charge->delete();
            }
        }
        $designation->delete();
        return redirect('/designation');
    }

    public function delete($id)
    {
        $designation = Designation::find($id);
        $staffDetails = StaffDetail::where( 'designation_id','=',$designation->id)->get();
        foreach($staffDetails as $staff)
        {
            $dailyInputs = DailyInput::where('user_id','=',$staff->id)->get();
            foreach($dailyInputs as $dialyinput)
            {
                $dialyinput->delete();
            }
            StaffDetail::destroy($staff->id);
        }
        if($designation->charge != null){
            $charges = $designation->charge;
            foreach($charges as $charge){
                Charge::destroy($charge->id);
            }
        }
        Designation::destroy($designation->id);
        return redirect('/designation');
    }

    public function updateDesignation(Request $request)
    {
        $designationdb = Designation::find($request->input('id'));
        $designationdb->title = $request->input('inputTitle');
        $designationdb->save();
        return redirect('/designation');
    }
}
