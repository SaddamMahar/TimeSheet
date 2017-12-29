<?php

namespace App\Http\Controllers;

use App\Model\Charge;
use App\Model\Designation;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $charges = Charge::all();
        $designations = Designation::all();
        return View('charge/charge')->with("charges",$charges)->with('designations',$designations);
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
            'upto'=>$request->input('inputvalidationDate'),
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
    public function edit($charge)
    {
//        return View("charge/chargeEdit")->with('charge',$charge)->with('designations',Designation::all());
        $data = Charge::find($charge);
        echo json_encode($data);
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

    public function delete($id)
    {
        $charge = Charge::find($id);
        Charge::destroy($charge->id);
        return redirect('/charge');
    }

    public function updateCharge(Request $request)
    {
        $chargedb = Charge::find($request->input('id'));
        $chargedb->rate = $request->input('inputRate');
        $chargedb->upto =$request->input('inputUpto');
        $chargedb->designation_id =$request->input('inputDesignation');
        $chargedb->save();
        return redirect('/charge');
    }
}
