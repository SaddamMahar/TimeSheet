
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DailyInput</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/docs/4.0/examples/signin/signin.css" rel="stylesheet">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
</head>

<body>

<div class="container">

    <form class="form-signin" method="post" action="{{ URL::to('dailyInput') }}">
        {!! csrf_field() !!}
        <h2 class="form-signin-heading">Daily Input</h2>
        Staff Name        : <select name="inputStaffDetail">
            <option value="0" label="--- Select ---"/>
            @foreach($staffDetails as $staffDetail)
                <option value="{{$staffDetail->id}}" label="{{$staffDetail->name}}"/>
            @endforeach
        </select><br />

        Client Name        : <select name="inputClient">
            <option value="0" label="--- Select ---"/>
            @foreach($clients as $client)
                <option value="{{$client->id}}" label="{{$client->name}}"/>
            @endforeach
        </select><br />


        <strong>Timepicker(From):</strong>

        <input class="timepicker form-control" type="text" id="inputTimeFrom" name="inputTimeFrom">

        <strong>Timepicker(upto):</strong>

        <input class="timepicker form-control" type="text" id="inputTimeUpto" name="inputTimeUpto">

        <td>
            <label for="inputReportDate" class="sr-only">ReportDate</label>
            <input type="date" id="inputReportDate" name="inputReportDate" class="form-control" value="" required autofocus>
        </td>
        <br />
        <td>
            <label for="inputTimeTotal" class="sr-only">TotalTime</label>
            <input type="text" id="inputTimeTotal" name="inputTimeTotal" class="form-control" value="" placeholder="Total Time in hours:minuts" required autofocus>
        </td>
        <br/>
        <button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Register</button>
    </form>

</div>
<!-- /container -->


<script type="text/javascript">

    $('.timepicker').datetimepicker({

        format: 'HH:mm:ss'

    });

</script>
</body>
</html>
