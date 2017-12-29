
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

    <form action="{{ route('charge.update',    $charge->id) }}" method="POST">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <h2 class="form-signin-heading">Charge Edit</h2>

        <input type="hidden" id="id" name="id" class="form-control" value="{{$charge->id}}">

        <label for="inputRate" class="sr-only">Rate</label>
        <input type="text" id="inputRate" name="inputRate" class="form-control" value="{{$charge->rate}}" required autofocus>

        <label for="inputUpto" class="sr-only">Upto</label>
        <input type="date" id="inputUpto" name="inputUpto" class="form-control" value="{{$charge->upto}}" required>

        Designation        : <select name="inputDesignation">
            <option value="{{$charge->designation->id}}" label="{{$charge->designation->title}}"/>
            @foreach($designations as $designation)
            <option value="{{$designation->id}}" label="{{$designation->title}}"/>
                @endforeach
        </select><br />

        <br />
        <button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Update</button>
    </form>

</div>
<!-- /container -->
</body>
</html>
