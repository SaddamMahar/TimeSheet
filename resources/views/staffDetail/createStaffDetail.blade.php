
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>StaffDetail</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/docs/4.0/examples/signin/signin.css" rel="stylesheet">
</head>

<body>

<div class="container">

    <form class="form-signin" method="post" action="{{ URL::to('staffDetail') }}">
        {!! csrf_field() !!}
        <h2 class="form-signin-heading">New Staff Detail</h2>

        <label for="inputName" class="sr-only">Name</label>
        <input type="text" id="inputName" name="inputName" class="form-control" placeholder="Name" required autofocus>


        <label for="inputEmail" class="sr-only">Email</label>
        <input type="text" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email" required>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="text" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>

        <label for="inputJoiningDate">Joining Date:</label>
        <input type="date" id="inputJoiningDate" name="inputJoiningDate" class="form-control" required>

        Designation        : <select name="inputDesignation">
            <option value="0" label="--- Select ---"/>
            @foreach($designations as $designation)
            <option value="{{$designation->id}}" label="{{$designation->title}}"/>
                @endforeach
        </select><br />
        <br />
        <button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Register</button>
    </form>

</div>
<!-- /container -->
</body>
</html>
