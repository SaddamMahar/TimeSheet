
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>StaffDetails</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/docs/4.0/examples/signin/signin.css" rel="stylesheet">
</head>

<body>

<div class="container">

    <form action="{{ route('dailyInput.update',    $dailyInput->id) }}" method="POST">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <h2 class="form-signin-heading">Daily Input Edit</h2>

        <input type="hidden" id="id" name="id" class="form-control" value="{{$dailyInput->id}}">

        Staff Name        : <select name="inputStaffDetail">
            <option value="{{$dailyInput->staffDetail->id}}" label="{{$dailyInput->staffDetail->name}}"/>
            @foreach($staffDetails as $staffDetail)
                <option value="{{$staffDetail->id}}" label="{{$staffDetail->name}}"/>
            @endforeach
        </select><br />

        Client Name        : <select name="inputClient">
            <option value="{{$dailyInput->client->id}}" label="{{$dailyInput->client->name}}"/>
            @foreach($clients as $client)
                <option value="{{$client->id}}" label="{{$client->name}}"/>
            @endforeach
        </select><br />

        <label for="inputCreated" class="sr-only">Created</label>
        <input type="text" id="inputCreated" name="inputCreated" class="form-control" value="{{$dailyInput->created}}" readonly>

        <p>Optional</p>
        <label for="inputTimeFrom" class="sr-only">Time From</label>
        <input type="text" id="inputTimeFrom" name="inputTimeFrom" class="form-control" value="{{$dailyInput->timeFrom}}" >

        <p>Optional</p>
        <label for="inputTimeUpto" class="sr-only">Time To</label>
        <input type="text" id="inputTimeUpto" name="inputTimeUpto" class="form-control" value="{{$dailyInput->timeUpto}}" >

        <td>
            <label for="inputTimeTotal" class="sr-only">TotalTime</label>
            <input type="text" id="inputTimeTotal" name="inputTimeTotal" class="form-control" value="{{$dailyInput->timeTotal}}" placeholder="Total Time in hours:minuts" required autofocus>
        </td>

        <td>
            <label for="inputReportDate" class="sr-only">Date</label>
            <input type="date" id="inputReportDate" name="inputReportDate" class="form-control" value="{{$dailyInput->reportDate}}" required autofocus>
        </td>
        <br />
        <button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Update</button>
    </form>

</div>
<!-- /container -->
</body>
</html>
