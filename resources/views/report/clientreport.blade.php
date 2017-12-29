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





    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>



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



            <!-- loop modal -->

            <form action="{{ url::to('report/clientreport') }}" method="POST" id="form">

                {{ csrf_field() }}

                <div class="row"><div class="col-md-12">

                        <div class="col-sm-4 text-center">

                            <label for="inputReportDate">Report From</label>

                            <input type="text" name="fromdate" class="datepick"  value="{{ isset($_POST['fromdate'])  && $_POST['fromdate'] !=null ? $_POST['fromdate'] : '' }}">

                        </div>

                        <div class="col-sm-4 text-center">

                            <label for="inputReportDate">To</label>

                            <input type="text" name="todate" class="datepick" value="{{ isset($_POST['todate'])  && $_POST['todate'] !=null ? $_POST['todate'] : '' }}" >

                        </div>

                        <?php $clients = \App\Model\Client::pluck('name','id'); ?>

                        <div class="col-sm-2 text-center">



                            <select name="client_id">

                                <option value="all" {{ isset($_POST['client_id']) && $_POST['client_id'] == 'all' ? 'selected' :'' }}>Combined</option>

                                <option value="indvidual" {{ isset($_POST['client_id']) && $_POST['client_id'] == 'indvidual' ? 'selected' :'' }}>Indvidual</option>

                                @foreach($clients as $key => $role)

                                    <option value="{{ $key }} " {{ isset($_POST['client_id']) && $_POST['client_id'] == $key ? 'selected' :'' }}> {{ $role }} </option>

                                @endforeach

                            </select>

                        </div>



                        <div class="col-sm-2 text-left">

                            <button type="submit" name="submit">Fetch Report</button>

                        </div>

                    </div>

                </div>

            </form>

            <div class="col-md-12">

                <?php



                if($flag == 'all' || $flag == null){

                if($data == null){

                    echo  'No data Found';

                }else{



                $totalhours = 0; //todo this need to be dynamic/changable per day hours

                if($totalDays !=null ){

                    // todo here we have formula for total staff * working hours = 8 * total working days

                    $totalhours = 8*$totalDays;

                }



                $rowData = '';

                $totalTime = null;



                foreach($data as $item){

                    $parts = explode(':', $item->ttime);

                    $seconds = ($parts[0] * 3600) + ($parts[1] * 60) + $parts[2];

                    $totalTime += $seconds;

                    $time = explode(':',$item->ttime);



                    $rowData .=   '["' . $item->title . '",' .   $time[0]  .'],';

                }



                $hours = floor($totalTime / 3600);

                $minutes = floor(($totalTime / 60) % 60);



                $clientName = isset($data[0]->name) && $data[0]->name != null &&  $flag == null ? $data[0]->name : '';

 ?>



                <html>

                <head>

                    <script type="text/javascript">

                        google.charts.load("current", {packages:["corechart"]});

                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {

                            var data = google.visualization.arrayToDataTable([

                                ['Task', 'Hours per Day'],

                                <?php echo $rowData; ?>



                            ]);



                            var options = {

                                title: '<?php echo  $clientName. '( Total Hours: ' .$hours .':'. $minutes .' )'  ; ?>',

                                pieHole: 0.4,

                            };



                            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));

                            chart.draw(data, options);

                        }

                    </script>

                </head>

                <body>

                <div id="donutchart" style="width: 900px; height: 500px;"></div>

                </body>

                </html>

                <?php } }



                else if($flag == 'indvidual'){



                if($data == null){

                    echo  'No data Found';

                }else{



                $totalhours = 8; //todo this need to be dynamic/changable per day hours

                if($totalDays != null){

                    $totalhours = $totalDays*$totalhours;

                }



            foreach($data as $keys => $items){

                    $totalTime = null;

                    $rowData = '';

                    foreach($items as $key => $item){



                    $parts = explode(':', $item->ttime);

                    $seconds = ($parts[0] * 3600) + ($parts[1] * 60) + $parts[2];

                    $totalTime += $seconds;

                    $time = explode(':',$item->ttime);



                    $rowData .=   '["' . $item->title . '",' .   $time[0]  .'],';



                    $hours = floor($totalTime / 3600);

                    $minutes = floor(($totalTime / 60) % 60);



                        }

                    ?>



                        <script type="text/javascript">

                            google.charts.load("current", {packages:["corechart"]});

                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {

                                var data = google.visualization.arrayToDataTable([

                                    ['Task', 'Hours per Day'],

                                    <?php echo $rowData; ?>



                                ]);



                                var options = {

                                    title: '<?php echo  $items[0]->clientName . ' ( Total Hours: ' .$hours .' )' ; ?>',

                                    pieHole: 0.4,

                                    'width':550,

                                    'height':550

                                };



                                var chart = new google.visualization.PieChart(document.getElementById('donutchart<?php echo $items[0]->id; ?>'));

                                chart.draw(data, options);

                            }

                        </script>

                    <div class="col-md-6">

                    <div id="donutchart<?php echo $items[0]->id; ?>" style="width: 900px; height: 500px;"></div>
                    </div>

                <?php } ?>



                <?php } }



                ?>

            </div>

        </div>

    </div>

</section>

<!-- Modal -->



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






