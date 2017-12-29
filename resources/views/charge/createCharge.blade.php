
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

    <form class="form-signin" method="post" action="{{ URL::to('charge') }}">
        {!! csrf_field() !!}
        <h2 class="form-signin-heading">New Charge</h2>

        <label for="inputRate" class="sr-only">Rate</label>
        <input type="text" id="inputRate" name="inputRate" class="form-control" placeholder="Rate" required autofocus>

        <label for="inputUpto" class="sr-only">Upto</label>
        <input type="date" id="inputUpto" name="inputUpto" class="form-control" placeholder="Upto" required>

        {{--<label for="inputContact" class="sr-only">Contact</label>--}}
        {{--<input type="text" id="inputContact" name="inputContact" class="form-control" placeholder="Contact" required>--}}

        Type        : <select name="inputDesignation">
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
