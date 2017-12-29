<!doctype html>

<html lang="en">

<head>

    <title>Dashboard</title>



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
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('client') }}">Clients </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('staffDetail') }}">Staff </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('task') }}">Task </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('designation') }}">Designation </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('charge') }}">Charges </a></li>
                        <li ><a href="{{ URL::to('dailyInput') }}">DailyInputs </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('admin') }}">Details </a></li>
                        <li class="dropdown active">
                            @if(\Illuminate\Support\Facades\Auth::user()->role->id == 1)
                                <a href="#" id="drop4" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Report </a>
                                <ul class="dropdown-menu" id="menu1" aria-labelledby="drop4">
                                    <li><a href="{{ URL::to('report/pie') }}">Employee</a></li>
                                    <li><a href="{{ URL::to('report/clientreport') }}">Client</a></li>
                                </ul>
                            @else
                                <a href="{{ URL::to('report/pie') }}">Report </a>
                            @endif
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="rightNav">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>

    </div>

</header>

<section class="main">

    <div class="container">

        <h2 class="heading-main">Dashboard  {{--<span class="addIcon" data-toggle="modal" data-target="#myModal" onclick="$('#formFirst')[0].reset();"><i><img src="{{asset('img/add.png')}}" alt=""></i>Add</span>--}}</h2>



        <div class="row">

<div class="col-md-12">
    <div id="meter_div" style="width: 400px; height: 120px;"></div>
</div>


            <div class="col-md-12">
                <div class="col-md-6">
                    <div id="chart_div" style="width: 510px; height: 500px;"></div>
                </div>
                <div class="col-md-6">
                    <div id="donutchart" style="width: 500px; height: 500px;"></div>

                </div>
            </div>
            <div class="col-md-12">
                <div id="table_div"></div>
            </div>


        </div>

    </div>

</section>

<!-- Modal -->




<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>

<script src="{{asset('js/bootstrap.min.js')}}"></script>

<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>



<script>
    $(document).ready(function () {
        $(".datepick").datepicker({format: 'yyyy-mm-dd'});
    })
</script>
<?php
if($monthdata == null){

    echo  'No data Found';

}else{



$rowData = '';

$totalTime = null;
$hours = null;
foreach($monthdata as $item){

    $timestamp = strtotime($item->created);
    $day = date("d", $timestamp);

//        $date = \DateTime::createFromFormat("Y-m-d", $item->created_at);

    $parts = explode(':', $item->ttime);

    $seconds = ($parts[0] * 3600) + ($parts[1] * 60) + $parts[2];

    $totalTime = $seconds;

    $time = explode(':',$item->ttime);



    $hour = floor($totalTime / 3600);


    $hours = $hour . ',';
    $rowData .=   '["'.''.$day.'", ' . $hours . '],';

}

?>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([
                ['Days', 'Hours', ],
                <?php echo $rowData; ?>

            ]);

            var options = {
                title : 'Monthly Hours',
                hAxis: {title: 'Hours'},
                hAxis: {title: 'Monthly'},
                seriesType: 'bars',
                series: {5: {type: 'line'}}
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</head>

<?php } ?>


<?php
$rowsData = '';

$totalTime2 = null;

foreach($data as $item){

    $parts = explode(':', $item->ttime);

    $seconds = ($parts[0] * 3600) + ($parts[1] * 60) + $parts[2];

    $totalTime2 += $seconds;

    $time = explode(':',$item->ttime);



    $rowsData .=   '["' . $item->clientname . '",' .   $time[0]  .'],';

}



$hours = floor($totalTime2 / 3600);

$minutes = floor(($totalTime / 60) % 60);

$seconds = $totalTime % 60;

$totalhours = 8*$totalDays;



$wastedHours = $totalhours - $hours;

$thours = $hours;
$twastedHours = $wastedHours;

$rowsData .=   '["' . 'Wasted Hours' . '",' .  $wastedHours   .'],';
?>

<script type="text/javascript">

    google.charts.load("current", {packages:["corechart"]});

    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([

            ['Task', 'Hours per Day'],

            <?php echo $rowsData; ?>



        ]);



        var options = {

            title: '<?php echo  '( Total Hours: ' .$totalhours .' ) ( Working Hours :'. $hours.' )  ( Wasted Hours :' . $wastedHours .' )' ; ?>',

            pieHole: 0.4,

        };



        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));

        chart.draw(data, options);

    }

</script>

<?php
$row = null;
foreach($tableData as $item){
    $parts = explode(':', $item->ttime);

    $seconds = ($parts[0] * 3600) + ($parts[1] * 60) + $parts[2];

    $Time = $seconds;
    $hours = floor($Time / 3600);

    $row .= '["'. $item->clientname . '", ' . $hours . ', "' . $item->created . '"],';


}
//dd($row);
?>


<head>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['table']});
        google.charts.setOnLoadCallback(drawTable);

        function drawTable() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Client');
            data.addColumn('number', 'Hours');
            data.addColumn('string', 'Date');
            data.addRows([
                <?php echo $row; ?>
            ]);

            var table = new google.visualization.Table(document.getElementById('table_div'));

            table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
        }
    </script>
</head>


<head>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Working Hours', <?php echo $thours; ?>],
                ['Wasted Hours', <?php echo $twastedHours; ?>],
            ]);

     
            var options = {
                width: 400, height: 120,
                redFrom: 90, redTo: 100,
                yellowFrom:75, yellowTo: 90,
                minorTicks: 5
            };

            var chart = new google.visualization.Gauge(document.getElementById('meter_div'));

            chart.draw(data, options);

            setInterval(function() {
                data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
                chart.draw(data, options);
            }, 13000);
            setInterval(function() {
                data.setValue(1, 1, 40 + Math.round(60 * Math.random()));
                chart.draw(data, options);
            }, 5000);
            setInterval(function() {
                data.setValue(2, 1, 60 + Math.round(20 * Math.random()));
                chart.draw(data, options);
            }, 26000);
        }
    </script>
</head>

