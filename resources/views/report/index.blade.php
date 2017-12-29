<!doctype html>

<html lang="en">

<head>

    <title>Report</title>



    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}} " />

    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.min.css')}} " />

    <link rel="stylesheet" href="{{asset('css/style.css')}} " />







    <script src="{{asset('js/jquery-3.2.1.min.js')}} "></script>

</head>

<body>

<header>

    <div class="container">

        <div class="header-main">

            <div class="leftNav">

                <nav>
                    <ul>
			<li class="active"><a href="{{ URL::to('home') }}">Home </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('client') }}">Clients </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('staffDetail') }}">Staff </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('task') }}">Task </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('designation') }}">Designation </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('charge') }}">Charges </a></li>
                        <li ><a href="{{ URL::to('dailyInput') }}">DailyInputs </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('admin') }}">Details </a></li>
                        <li class="dropdown active">
                            <a href="#" id="drop4" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Report </a>
                            <ul class="dropdown-menu" id="menu1" aria-labelledby="drop4">
                                <li><a href="{{ URL::to('report/pie') }}">Employee</a></li>
                                <li><a href="{{ URL::to('report/clientreport') }}">Client</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>

<div class="rightNav">
                <ul>
                    <li><a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                            <i class="glyphicon glyphicon-triangle-bottom"></i>
                        </a>
                        <ul>
                            <li><a href="#" data-toggle="modal" data-target="#myModal3" >
                                    Reset Password
                                </a></li>
                        </ul>
                    </li>
                </ul>


                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>

    </div>

</header>

<section class="main">

    <div class="container">

        <h2 class="heading-main">Client  {{--<span class="addIcon" data-toggle="modal" data-target="#myModal" onclick="$('#formFirst')[0].reset();"><i><img src="{{asset('img/add.png')}}" alt=""></i>Add</span>--}}</h2>



        <div class="row">

            <div class="col-sm-12">

                <div class="main-table">

                    <table class="table">

                        <thead>

                        <tr>

                            <th>Name</th>

                            <th>Address</th>

                            <th>Contact</th>

                            <th>Contact Person</th>

                            <th>Ntn</th>

                            <th>Action</th>

                        </tr>

                        </thead>



                        <tbody>

                        @if(isset($clients))

                            @foreach($clients as $client)

                                <tr>

                                    <td>{{$client->name}}</td>

                                    <td>{{$client->address}}</td>

                                    <td>{{$client->contact}}</td>

                                    <td>{{$client->contactPerson}}</td>

                                    <td>{{$client->nic}}</td>

                                    <td>

                                        <ul class="list-inline">

                                            <li>

                                                {{--<a href="{{ URL::to('client/'.$client->id.'/edit/') }}" ><img src="{{asset('img/edit.png')}}" alt=""></a>--}}

                                                <a href="#" data-toggle="modal" data-target="#myModal2" onclick="edit_book({{$client->id}})" ><img src="{{asset('img/edit.png')}}" alt=""></a>

                                            </li>

                                            <li><a href="{{ URL::to('client/delete/'.$client->id) }}"><img src="{{asset('img/remove.png')}}" alt=""></a></li>

                                            <li><a href="#"><img src="{{asset('img/recycle.png')}}" alt=""></a></li>

                                        </ul>

                                    </td>

                                </tr>

                            @endforeach

                        @endif

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- Modal -->

<div class="modal fade modal-small" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <span data-dismiss="modal" aria-label="Close" aria-hidden="true" class="closeFixed">&times;</span>

                <h2 class="modal-title" id="myModalLabel">Client Detail</h2>

            </div>





            <form class="form-signin" method="post" action="{{ URL::to('client') }}" id="formFirst">

                {!! csrf_field() !!}

                <div class="modal-body">

                    <input type="hidden" name="id">

                    <input name="inputName" type="text" placeholder="Name">

                    <input type="text" name="inputAddress" placeholder="Address">

                    <input type="text" name="inputContact" placeholder="Phone Number">

                    <input type="text" name="inputContactPerson" placeholder="Contact Person">

                    <input type="text" name="inputnic" placeholder="NTN">

                </div>

                <div class="modal-footer">

                    <div class="row">

                        <div class="col-xs-6 text-center">

                            <button type="submit" >Submit</button>

                        </div>

                        <div class="col-xs-6 text-center">

                            <button type="button" data-dismiss="modal">Exit</button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>





<!-- loop modal -->





<form action="{{ url::to('report/index') }}" method="POST" id="form">

    {{ csrf_field() }}

    <div class="row"><div class="col-md-12">

            <div class="col-sm-3 text-center">

                <label for="inputReportDate">Report From</label>

                <input type="text" name="fromdate" class="datepick"  value="{{ isset($_POST['fromdate'])  && $_POST['fromdate'] !=null ? $_POST['fromdate'] : '' }}">

            </div>

            <div class="col-sm-2 text-center">

                <label for="inputReportDate">To</label>

                <input type="text" name="todate" class="datepick" value="{{ isset($_POST['todate'])  && $_POST['todate'] !=null ? $_POST['todate'] : '' }}" >

            </div>

            <?php $stffDetails = \App\Model\StaffDetail::pluck('name','id'); ?>

            <div class="col-sm-2 text-center">

                <select name="staff_id">

                    @foreach($stffDetails as $key => $role)

                        <option value="{{ $key }} " {{ isset($_POST['staff_id']) && $_POST['staff_id'] == $key ? 'selected' :'' }}> {{ $role }} </option>

                    @endforeach

                </select>

            </div>

            <div class="col-sm-2 text-left">

                <button type="submit" name="submit">Fetch Report</button>

            </div>

        </div>

    </div>

</form>









<?php



if( $data == null ) {

    echo  'No data found for this date ';

    }else{

$rowData = '';

$color = [];

$color = ['gold','#e5e4e2','red','blue','black','#c000','#FF00FF','#C0C0C0','#808000','#87CEEB','#7B68EE','#A52A2A','#8FBC8F','#2F4F4F','#483D8B'];

$i = 0;

foreach ($data as $item) {

    $time = explode(':',$item->ttime);

//    $time = str_replace(':','.',$item->ttime);

    $rowData .= '["'.$item->title .'",' . $time[0] . ', "'.$color[$i] .'"],';



$i++;

}

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">

    google.charts.load("current", {packages:['corechart']});

    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([

            ["Element", "Hours", { role: "style" } ],

           <?php echo $rowData; ?>

        ]);



        var view = new google.visualization.DataView(data);

        view.setColumns([0, 1,

            { calc: "stringify",

                sourceColumn: 1,

                type: "string",

                role: "annotation" },

            2]);



        var options = {

            chart: {

                title: 'Company Performance',

                subtitle: 'Sales, Expenses, and Profit: 2014-2017',

            }

        };

        var options = {

            title: "<?php echo $data[0]->clientName; ?>",

            width: 600,

            height: 400,

            bar: {groupWidth: "95%"},

            legend: { position: "none" },

        };

        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));

        chart.draw(view, options);

    }

</script>



<?php

 }



?>

<div id="columnchart_values" style="width: 900px; height: 300px;"></div>




{{--password reset model--}}
<div class="modal fade modal-small" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span data-dismiss="modal" aria-label="Close" aria-hidden="true" class="closeFixed">×</span>
                <h2 class="modal-title" id="myModalLabel">Reset Password</h2>
            </div>
            <form action="{{ url::to('passwordReset') }}" method="POST" id="form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <label for="inputPassword">Old passwrod</label>
                    <input class="timepicker form-control" type="password" id="inputPassword" name="inputPassword">

                    <label for="inputNewPassword">New passwrod</label>
                    <input class="timepicker form-control" type="password" id="inputNewPassword" name="inputNewPassword">

                    <label for="inputNewConfirmPassword">New confirm passwrod</label>
                    <input class="timepicker form-control" type="password" id="inputNewConfirmPassword" name="inputNewConfirmPassword">

                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-6 text-center">
                            <button type="type" >Submit</button>
                        </div>
                        <div class="col-sm-6 text-center">
                            <button type="button" data-dismiss="modal">Exit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>

<script src="{{asset('js/bootstrap.min.js')}}"></script>

<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>



<script>





    $(document).ready(function () {

        $(".datepick").datepicker({format: 'yyyy-mm-dd'});

    })

</script>







</body>

</html>



























