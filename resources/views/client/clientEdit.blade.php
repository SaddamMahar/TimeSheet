
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/docs/4.0/examples/signin/signin.css" rel="stylesheet">
</head>

<body>

<div class="container">

    <form action="{{ route('client.update',    $client->id) }}" method="POST">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <h2 class="form-signin-heading">Client Registration</h2>

        <input type="hidden" id="id" name="id" class="form-control" value="{{$client->id}}">

        <label for="inputName" class="sr-only">Name</label>
        <input type="text" id="inputName" name="inputName" class="form-control" value="{{$client->name}}" required autofocus>

        <label for="inputAddress" class="sr-only">Address</label>
        <input type="text" id="inputAddress" name="inputAddress" class="form-control" value="{{$client->address}}" required>

        <label for="inputContact" class="sr-only">Contact</label>
        <input type="text" id="inputContact" name="inputContact" class="form-control" value="{{$client->contact}}" required>

        <label for="inputContactPerson" class="sr-only">Contact Person</label>
        <input type="text" id="inputContactPerson" name="inputContactPerson" class="form-control" value="{{$client->contactPerson}}" required>

        {{--<label for="inputJoiningDate" class="sr-only">Joining Date</label>--}}
        {{--<input type="date" id="inputJoiningDate" name="inputJoiningDate" class="form-control" required>--}}

        <label for="inputnic" class="sr-only">NIC</label>
        <input type="text" id="inputnic" name="inputnic" class="form-control" value="{{$client->nic}}" required>
        <br />
        <br />
        {{--<div class="checkbox">--}}
        {{--<label>--}}
        {{--<input type="checkbox" value="remember-me"> Remember me--}}
        {{--</label>--}}
        {{--</div>--}}
        <button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Update</button>
    </form>

</div>
<!-- /container -->
</body>
</html>
