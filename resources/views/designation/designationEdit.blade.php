
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/docs/4.0/examples/signin/signin.css" rel="stylesheet">
</head>

<body>

<div class="container">

    <form action="{{ route('designation.update',    $designation->id) }}" method="POST">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <h2 class="form-signin-heading">Designation Title</h2>

        <input type="hidden" id="id" name="id" class="form-control" value="{{$designation->id}}">

        <label for="inputTitle" class="sr-only">Title</label>
        <input type="text" id="inputTitle" name="inputTitle" class="form-control" value="{{$designation->title}}" required autofocus>

        <button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Update</button>
    </form>

</div>
<!-- /container -->
</body>
</html>
