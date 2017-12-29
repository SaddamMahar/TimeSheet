<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){


        $date = Carbon::now();
        $fromDate = $date->format('Y-m-1'); //From start
        $todate = $date->format('Y-m-d'); //current date
        $datetime1 = new \DateTime($fromDate);
        $datetime2 = new \DateTime($todate);
        $interval = $datetime1->diff($datetime2);
        $diffreneceBWDays =  $interval->format('%R%a days');
        $Days =intval(preg_replace('/[^0-9]+/', '', $diffreneceBWDays), 10);
        $totalDays = $Days +1;
        $monthdata = DB::table('users AS staff_detail')
            ->leftJoin('daily_inputs', 'staff_detail.id', '=', 'daily_inputs.user_id')
            ->leftJoin('client', 'daily_inputs.client_id', '=', 'client.id')
            ->select('staff_detail.*','client.name AS clientname','daily_inputs.created AS created',DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( `timeTotal` ) ) ) as ttime'))
            ->where('staff_detail.id', '=' ,$this->getCurrentUser())
            ->whereDate('created', '>=', $fromDate)
            ->whereDate('created', '<=', $todate)
            ->groupBy('created')
            ->get();

        $data = DB::table('users')
            ->leftJoin('daily_inputs', 'users.id', '=', 'daily_inputs.user_id')
            ->leftJoin('client', 'daily_inputs.client_id', '=', 'client.id')
            ->select('users.*','client.name AS clientname',DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( `timeTotal` ) ) ) as ttime'))
            ->where('users.id', '=' ,$this->getCurrentUser())
            ->whereDate('created', '>=', $fromDate)
            ->whereDate('created', '<=', $todate)
            ->groupBy('client_id')
            ->get();

        $tableData = DB::table('users AS staff_detail')
            ->leftJoin('daily_inputs', 'staff_detail.id', '=', 'daily_inputs.user_id')
            ->leftJoin('client', 'daily_inputs.client_id', '=', 'client.id')
            ->select('staff_detail.*','client.name AS clientname','daily_inputs.created AS created','daily_inputs.timeTotal AS ttime')
            ->where('staff_detail.id', '=' ,$this->getCurrentUser())
            ->whereDate('created', '>=', $fromDate)
            ->whereDate('created', '<=', $todate)
            ->limit(10)
            ->get();


        return   view('home',compact('monthdata','totalDays','data','tableData'));
    }

    public  function getCurrentUser(){
        return Auth::user()->id;

    }
}
