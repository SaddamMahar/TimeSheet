

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="css/style.css">

    <title>Leads</title>

</head>

<body>

<header>

    <div class="container">

        <div class="header-main">

            <div class="leftNav">

                <nav>

                    <ul>
			<li class="active"><a href="{{ URL::to('home') }}">Home </a></li>

                        <li><a href="{{ URL::to('client') }}">Clients </a></li>

                        <li><a href="{{ URL::to('staffDetail') }}">Staff </a></li>

                        <li><a href="{{ URL::to('task') }}">Task </a></li>

                        <li><a href="{{ URL::to('designation') }}">Designation </a></li>

                        <li class="active"><a href="{{ URL::to('charge') }}">Charges </a></li>

                        <li><a href="{{ URL::to('dailyInput') }}">DailyInputs </a></li>

			<li ><a href="{{ URL::to('admin') }}">Details </a></li>
					<li class="dropdown">

                            <a href="#" id="drop4" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Report </a>

                            <ul class="dropdown-menu" id="menu1" aria-labelledby="drop4">

                                <li><a href="{{ URL::to('report/pie') }}">Employee</a></li>

                                <li><a href="{{ URL::to('report/clientreport') }}">Client</a></li>

                            </ul>

                        </li>


                    </ul>

                </nav>

            </div>

            <div class="rightNav">
                <ul>
                    <li><a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                            <i class="glyphicon glyphicon-triangle-bottom"></i>
                        </a>
                        <ul>
                            <li><a href="#" data-toggle="modal" data-target="#myModal3" >
                                    Reset Password
                                </a></li>
                        </ul>
                    </li>
                </ul>


                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>

    </div>

</header>

<section class="main">

    <div class="container">

        <h2 class="heading-main">Charge<span class="addIcon" data-toggle="modal" data-target="#myModal" onclick="$('#formFirst')[0].reset();"><i><img src="img/add.png" alt=""></i>Add</span></h2>

        <div class="row">

            <div class="col-sm-12">

                <div class="main-table">

                    <table class="table">

                        <thead>

                        <tr>

                            <th>Designation</th>

                            <th>Rate</th>

                            <th>Validation</th>

                            <th>Action</th>

                        </tr>

                        </thead>

                        <tbody>

                        @if(isset($charges))

                            @foreach($charges as $charge)

                                <tr>

                                    <td>{{$charge->designation->title}}</td>

                                    <td>{{$charge->rate}}</td>

                                    <td>{{$charge->upto}}</td>

                                    <td>

                                        <ul class="list-inline">

                                            <li><a href="#"  data-toggle="modal" data-target="#myModal2" onclick="edit_book({{$charge->id}})"><img src="{{asset('img/edit.png')}}" alt=""></a></li>

                                            <li><a href="{{ URL::to('charge/delete/'.$charge->id) }}"><img src="{{asset('img/remove.png')}}" alt=""></a></li>

                                            <li><a href="#"><img src="{{asset('img/recycle.png')}}" alt=""></a></li>

                                        </ul>

                                    </td>

                                </tr>

                            @endforeach

                        @endif

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</section>



<!-- Modal -->

<div class="modal fade modal-small" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <span data-dismiss="modal" aria-label="Close" aria-hidden="true" class="closeFixed">&times;</span>

                <h2 class="modal-title" id="myModalLabel">Charge</h2>

            </div>

            <form class="form-signin" method="post" action="{{ URL::to('charge') }}" id="formFirst">

                {!! csrf_field() !!}

                <div class="modal-body">

                    <label for="inputDesignation">Designation</label>

                    <select name="inputDesignation" id="inputDesignation">

                        <option value="0">---Select---</option>

                        @if(isset($designations))

                            @foreach($designations as $designation)

                                <option value="{{$designation->id}}">{{$designation->title}}</option>

                            @endforeach

                        @endif

                    </select>

                    <input type="number" name="inputRate" placeholder="Rate">

                    <input type="date" name="inputvalidationDate" class="datepick" placeholder="valid upto">

                </div>

                <div class="modal-footer">

                    <div class="row">

                        <div class="col-sm-6 text-center">

                            <button type="type" >Submit</button>

                        </div>

                        <div class="col-sm-6 text-center">

                            <button type="button" data-dismiss="modal">Exit</button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>





<!-- Modal2 -->

<div class="modal fade modal-small" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <span data-dismiss="modal" aria-label="Close" aria-hidden="true" class="closeFixed">&times;</span>

                <h2 class="modal-title" id="myModalLabel">Charge</h2>

            </div>

            <form class="form-signin" method="post" action="{{ URL::to('charge/update') }}" id="form">

                {!! csrf_field() !!}

                <div class="modal-body">

                    <label for="inputDesignation">Designation</label>

                    <select name="inputDesignation" id="inputDesignation">

                        <option value="0">---Select---</option>

                        @if(isset($designations))

                            @foreach($designations as $designation)

                                <option value="{{$designation->id}}">{{$designation->title}}</option>

                            @endforeach

                        @endif

                    </select>

                    <input type="number" name="inputRate" placeholder="Rate">

                    <input type="hidden" name="id">

                    <input type="date" name="inputUpto" class="datepick" placeholder="valid upto">

                </div>

                <div class="modal-footer">

                    <div class="row">

                        <div class="col-sm-6 text-center">

                            <button type="type" >Submit</button>

                        </div>

                        <div class="col-sm-6 text-center">

                            <button type="button" data-dismiss="modal">Exit</button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>



{{--password reset model--}}
<div class="modal fade modal-small" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span data-dismiss="modal" aria-label="Close" aria-hidden="true" class="closeFixed">×</span>
                <h2 class="modal-title" id="myModalLabel">Reset Password</h2>
            </div>
            <form action="{{ url::to('passwordReset') }}" method="POST" id="form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <label for="inputPassword">Old passwrod</label>
                    <input class="timepicker form-control" type="password" id="inputPassword" name="inputPassword">

                    <label for="inputNewPassword">New passwrod</label>
                    <input class="timepicker form-control" type="password" id="inputNewPassword" name="inputNewPassword">

                    <label for="inputNewConfirmPassword">New confirm passwrod</label>
                    <input class="timepicker form-control" type="password" id="inputNewConfirmPassword" name="inputNewConfirmPassword">

                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-6 text-center">
                            <button type="type" >Submit</button>
                        </div>
                        <div class="col-sm-6 text-center">
                            <button type="button" data-dismiss="modal">Exit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




<script src="js/jquery-3.2.1.min.js"></script>

<script src="js/bootstrap.min.js"></script>

<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>



<script>



    function edit_book(id) {

        save_method = 'update';

        $('#form')[0].reset(); // reset form on modals

        var uri = '{{URL::to('/')}}';

        //Ajax Load data from ajax

        $.ajax({

            url: "{{ URL::to('charge')}}" +"/"+id+ '/edit/',

            type: "GET",

            dataType: "JSON",

            success: function (data) {



                console.log(data);

                $('[name="id"]').val(data.id);

                $('[name="inputDesignation"]').val(data.designation_id);

                $('[name="inputRate"]').val(data.rate);

                $('[name="inputUpto"]').val(data.upto);



            },

            error: function (jqXHR, textStatus, errorThrown) {

                alert('Error get data from ajax');

            }

        });

    }

    $(document).ready(function () {

        $(".datepick").datepicker({format: 'yyyy-mm-dd'});

    })

</script>



</body>

</html>