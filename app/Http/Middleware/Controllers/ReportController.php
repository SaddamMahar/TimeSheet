<?php



namespace App\Http\Controllers;


use App\Model\DailyInput;
use App\Model\StaffDetail;
use Carbon\Carbon;
use Couchbase\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;


class ReportController extends Controller{



    public function clientreport(){

        $date = Carbon::now();
        $fromDate =$date->format('Y-m-1'); //From current month start
        $todate = $date->format('Y-m-d'); //current date
        $clientId = null;
        $staffCount = null;
        $singleStaff = null ;
        $totalDays = null;
        $flag = null;

        if(isset($_REQUEST['submit'])){

            $fromDate = isset($_REQUEST['fromdate']) && $_REQUEST['fromdate'] != null ? $_REQUEST['fromdate'] : '';
            $todate = isset($_REQUEST['todate']) && $_REQUEST['todate'] != null ? $_REQUEST['todate'] : '';
            $clientId = isset($_REQUEST['client_id']) && $_REQUEST['client_id'] != null ? $_REQUEST['client_id'] : '';

        }
        $datetime1 = new \DateTime($fromDate);
        $datetime2 = new \DateTime($todate);
        $interval = $datetime1->diff($datetime2);
        $diffreneceBWDays =  $interval->format('%R%a days');
        $Days =intval(preg_replace('/[^0-9]+/', '', $diffreneceBWDays), 10);
        $totalDays = $Days +1;
        if($clientId == 'indvidual') {

            $data = DB::table('client')
                ->leftJoin('daily_inputs', 'daily_inputs.client_id', '=', 'client.id')
                ->leftJoin('users', 'daily_inputs.user_id', '=', 'users.id')
                ->leftJoin('designation', 'users.designation_id', '=', 'designation.id')
                ->select('client.*',DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( `timeTotal` ) ) ) as ttime'),
                    'client.name AS clientName','designation.id AS desgID','users.id AS sID',
                    'daily_inputs.id AS dID','designation.title AS title')
                ->whereDate('created', '>=', $fromDate)
                ->whereDate('created', '<=', $todate)
                ->groupBy('title','id')
                ->get()
                ->groupBy('id');
            $flag = 'indvidual';
        }elseif($clientId == 'all'){
            $data = DB::table('daily_inputs')
                ->leftJoin('users', 'daily_inputs.user_id', '=', 'users.id')
                ->leftJoin('designation', 'users.designation_id', '=', 'designation.id')
                ->leftJoin('client', 'daily_inputs.client_id', '=', 'client.id')
                ->select('*',DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( `timeTotal` ) ) ) as ttime'), 'client.name AS clientName')
                ->whereDate('created', '>=', $fromDate)
                ->whereDate('created', '<=', $todate)
                ->groupBy('title')
                ->get();
            $flag = 'all';
        }else{

        $data = DB::table('daily_inputs')
            ->leftJoin('users', 'daily_inputs.user_id', '=', 'users.id')
            ->leftJoin('designation', 'users.designation_id', '=', 'designation.id')
            ->leftJoin('client', 'daily_inputs.client_id', '=', 'client.id')
            ->select('*',DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( `timeTotal` ) ) ) as ttime'), 'client.name AS clientName')
            ->where('client_id', '=' ,$clientId)
            ->whereDate('created', '>=', $fromDate)
            ->whereDate('created', '<=', $todate)
            ->groupBy('title')
            ->get();
        }
        if( $data->isEmpty() ){
            $data = null;
        }


        return view('report.clientreport',compact('data','totalDays','flag'));
    }

    public function index(){

        $date = Carbon::now();
        $createdTime = $date->format('Y-m-d');

            if(isset($_REQUEST['ReportDate']) && $_REQUEST['ReportDate'] !=null){
                $createdTime = $_REQUEST['ReportDate'];
            }


            $data = DB::table('daily_inputs')
            ->leftJoin('users', 'daily_inputs.user_id', '=', 'users.id')
            ->leftJoin('designation', 'users.designation_id', '=', 'designation.id')
            ->leftJoin('client', 'daily_inputs.client_id', '=', 'client.id')
            ->select('*',DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( `timeTotal` ) ) ) as ttime'), 'client.name AS clientName')
            ->where('client_id', '=' ,'30')
            ->whereDate('created', '=', $createdTime)
            ->groupBy('title')
            ->get();
//            dd($data);
//             ->groupBy(function($date) {
//                return \Carbon\Carbon::parse($date->created)->format('d-M-y');
//            });
            if( $data->isEmpty() ){
                $data = null;
            }


        return   view('report.index',compact('data'));
    }

    public function pie(){

        //$date = Carbon::now();
        $fromDate ='2017-11-01'; //From start
        $todate = date('Y-m-d'); //current date
        $staff_id = 'all';
        $staffCount = null;
        $singleStaff = null ;
        $totalDays = null;
        $flag = null;
        if(isset($_REQUEST['submit'])){
            $fromDate = isset($_REQUEST['fromdate']) && $_REQUEST['fromdate'] != null ? $_REQUEST['fromdate'] : '';
            $todate = isset($_REQUEST['todate']) && $_REQUEST['todate'] != null ? $_REQUEST['todate'] : '';
            $staff_id = isset($_REQUEST['staff_id']) && $_REQUEST['staff_id'] != null ? $_REQUEST['staff_id'] : '';
            $datetime1 = new \DateTime($fromDate);
            $datetime2 = new \DateTime($todate);
            $interval = $datetime1->diff($datetime2);
            $diffreneceBWDays =  $interval->format('%R%a days');
            $Days =intval(preg_replace('/[^0-9]+/', '', $diffreneceBWDays), 10);
            $totalDays = $Days +1;

        }

        if($staff_id == 'all'){
            $data = DB::table('users AS staff_detail')
                ->leftJoin('daily_inputs', 'staff_detail.id', '=', 'daily_inputs.user_id')
                ->leftJoin('client', 'daily_inputs.client_id', '=', 'client.id')
                ->select('staff_detail.*','daily_inputs.id AS did','daily_inputs.timeTotal AS timeTotal'
                    ,'daily_inputs.created AS created'
                    ,'client.name AS clientname',DB::raw('COUNT( created ) AS days'),DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( `timeTotal` ) ) ) as ttime'))
                ->whereDate('created', '>=', $fromDate)
                ->whereDate('created', '<=', $todate)
                ->groupBy('client_id')
                ->get();


//            $totalDays = DB::table('daily_inputs')
//                ->select('*')
//                ->whereDate('created', '>=', $fromDate)
//                ->whereDate('created', '<=', $todate)
//                ->get()
//           ->groupBy(function($date) {
//                return \Carbon\Carbon::parse($date->created)->format('d-M-y');
//            })->count();

                $staffCount = StaffDetail::all()->count();
            $flag = 'all';
        }else if($staff_id == 'indvidual'){
            $data = DB::table('users')
                ->leftJoin('daily_inputs', 'users.id', '=', 'daily_inputs.user_id')
                ->leftJoin('client', 'daily_inputs.client_id', '=', 'client.id')
                ->select('users.*','daily_inputs.id AS did','daily_inputs.timeTotal AS timeTotal'
                    ,'daily_inputs.created AS created'
                    ,'client.name AS clientname',DB::raw('COUNT( created ) AS days'),DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( `timeTotal` ) ) ) as ttime'))
                ->whereDate('created', '>=', $fromDate)
                ->whereDate('created', '<=', $todate)
                ->groupBy('users.id','clientname')
                ->get()
                ->groupBy('id');;

            $staffCount = StaffDetail::all()->count();
            $flag = 'indvidual';
        } else{

        $data = DB::table('users AS staff_detail')
            ->leftJoin('daily_inputs', 'staff_detail.id', '=', 'daily_inputs.user_id')
            ->leftJoin('client', 'daily_inputs.client_id', '=', 'client.id')
            ->select('staff_detail.*','client.name AS clientname',DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( `timeTotal` ) ) ) as ttime'))
            ->where('staff_detail.id', '=' ,$staff_id)
            ->whereDate('created', '>=', $fromDate)
            ->whereDate('created', '<=', $todate)
            ->groupBy('client_id')
            ->get();


//            $totalDays = DB::table('daily_inputs')
//                ->select('*')
//                ->where('user_id', '=' ,$staff_id)
//                ->whereDate('created', '>=', $fromDate)
//                ->whereDate('created', '<=', $todate)
//                ->get()
//                ->groupBy(function($date) {
//                    return \Carbon\Carbon::parse($date->created)->format('d-M-y');
//                })->count();
        }

        if( $data->isEmpty() ){
            $data = null;
        }

        return   view('report.pie',compact('data','staffCount','totalDays','flag'));
    }


    public function allstff(){
        $date = Carbon::now();
        $fromDate =$date->format('1971-1-1'); //From start
        $todate = $date->format('Y-m-d'); //current date


        $data = DB::table('staff_detail')
            ->leftJoin('daily_inputs', 'staff_detail.id', '=', 'daily_inputs.user_id')
            ->leftJoin('client', 'daily_inputs.client_id', '=', 'client.id')
            ->select('staff_detail.*','daily_inputs.id AS did','daily_inputs.timeTotal AS timeTotal'
                ,'daily_inputs.created AS created'
                ,'client.name AS clientname',DB::raw('COUNT( created ) AS days'),DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( `timeTotal` ) ) ) as ttime'))
            ->whereDate('created', '>=', $fromDate)
            ->whereDate('created', '<=', $todate)
            ->groupBy('staff_detail.id')
            ->get();

        $staffCount = StaffDetail::all()->count();
        if( $data->isEmpty() ){
            $data = null;
        }

        return   view('report.allstaff',compact('data','staffCount','totalDays'));
    }
    public  function getCurrentUser(){
          return Auth::user()->id;

    }



    public function monthlyChart(){


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


        return   view('report.monthlychart',compact('monthdata','totalDays','data','tableData'));
    }




}