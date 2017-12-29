
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Charge</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/docs/4.0/examples/signin/signin.css" rel="stylesheet">
</head>

<body>

<div class="container">

    <form class="form-signin" method="post" action="{{ URL::to('task') }}">
        {!! csrf_field() !!}
        <h2 class="form-signin-heading">New Task</h2>

        <label for="inputName" class="sr-only">Name</label>
        <input type="text" id="inputName" name="inputName" class="form-control" placeholder="Task" required autofocus>

        <br />
        <button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Create</button>
    </form>

</div>
<!-- /container -->
</body>
</html>
