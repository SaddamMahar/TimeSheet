
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

    <form action="{{ route('staffDetail.update',    $staffDetail->id) }}" method="POST">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <h2 class="form-signin-heading">Staff Detail Edit</h2>

        <input type="hidden" id="id" name="id" class="form-control" value="{{$staffDetail->id}}">

        <label for="inputName" class="sr-only">Name</label>
        <input type="text" id="inputName" name="inputName" class="form-control" value="{{$staffDetail->name}}" required autofocus>

        <label for="inputEmail" class="sr-only">Email</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" value="{{$staffDetail->email}}" required>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="text" id="inputPassword" name="inputPassword" class="form-control" value="{{$staffDetail->password}}" required>

        <label for="inputJoiningDate" class="sr-only">Joining Date</label>
        <input type="date" id="inputJoiningDate" name="inputJoiningDate" class="form-control" value="{{$staffDetail->joiningDate}}" required>

        <label for="inputLeavingDate" class="sr-only">Leaving Date</label>
        <input type="date" id="inputLeavingDate" name="inputLeavingDate" class="form-control" value="{{$staffDetail->leavingDate}}" required>

        Designation        : <select name="inputDesignation">
            <option value="{{$staffDetail->designation->id}}" label="{{$staffDetail->designation->title}}"/>
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
