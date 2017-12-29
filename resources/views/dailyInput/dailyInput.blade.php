
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
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('client') }}">Clients </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('staffDetail') }}">Staff </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('task') }}">Task </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('designation') }}">Designation </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('charge') }}">Charges </a></li>
                        <li class="active" ><a href="{{ URL::to('dailyInput') }}">DailyInputs </a></li>
                        <li class="<?php if(\Illuminate\Support\Facades\Auth::user()->role->id == '2'){echo 'hide';}echo '';?>"><a href="{{ URL::to('admin') }}">Details </a></li>
                        <li class="dropdown">

                            @if(\Illuminate\Support\Facades\Auth::user()->role->id == 1)
                                <a href="#" id="drop4" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Report </a>
                            <ul class="dropdown-menu" id="menu1" aria-labelledby="drop4">

                                <li><a href="{{ URL::to('report/pie') }}">Employee</a></li>
                                <li><a href="{{ URL::to('report/clientreport') }}">Client</a></li>
                            </ul>
                                @else
                                <a href="{{ URL::to('report/pie') }}">Report </a>
                            @endif
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
        <h2 class="heading-main">Daily Input<span class="addIcon" data-toggle="modal" data-target="#myModal" onclick="$('#formFirst')[0].reset();"><i><img src="{{asset('img/add.png')}}" alt=""></i>Add</span></h2>

        {{--filters--}}
        <div class="row">
            <form method="post" action="{{ URL::to('dailyInput')}}">
                {!! csrf_field() !!}
                <div class="col-sm-3">
                    <div class="dropdownContainer">
                        @if(isset($from))
                            <input type="text" name="from" class="datepick" placeholder="Start date" value="{{$from}}"
                                   onchange="this.form.submit()">
                        @else
                            <input type="text" name="from" class="datepick" placeholder="Start date"
                                   onchange="this.form.submit()">
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="dropdownContainer">
                        @if(isset($upto))
                            <input type="text" name="upto" value="{{$upto}}" class="datepick" placeholder="End date"
                                   onchange="this.form.submit()">
                        @else
                            <input type="text" name="upto" class="datepick" placeholder="End date"
                                   onchange="this.form.submit()">
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="dropdownContainer">
                        <div class="fieldWithLabel Cell">
                            <label for="inputClient">Client</label>
                            <select name="inputClient" id="inputClient" onchange="this.form.submit()">
                                @if(isset($client))
                                    <option selected value="{{$client->id}}" label="{{$client->name}}"/>
                                @else
                                    <option value="0">---Select---</option>
                                @endif
                                @foreach($clients as $client)
                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    @if(\Illuminate\Support\Facades\Auth::user()->role->id == 1)
                    <div class="dropdownContainer">
                        <div class="fieldWithLabel Cell">
                            <label for="inputStaffDetail">Staff</label>
                            <select name="inputStaffDetail" id="inputStaffDetail" onchange="this.form.submit()">
                                @if(isset($staffDetail))
                                    <option selected value="{{$staffDetail->id}}" label="{{$staffDetail->name}}"/>
                                @else
                                    <option value="0">---Select---</option>
                                @endif
                                @foreach($staffDetails as $staffDetail)
                                    <option value="{{$staffDetail->id}}">{{$staffDetail->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        @endif
                </div>
            </form>
        </div>

        {{--filters end--}}
        <div class="row">
            <div class="col-sm-12">
                <div class="main-table">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Client</th>
                            <th>Staff</th>
                            <th>Date</th>
                            <th>Time From</th>
                            <th>Time Upto</th>
                            <th>Total Time</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($dailyInputs))
                            @foreach($dailyInputs as $dailyInput)
                                <tr>
                                    <td>{{isset($dailyInput->client)?$dailyInput->client->name:''}}</td>
                                    <td>{{isset($dailyInput->user)?$dailyInput->user->name:''}}</td>
                                    <td> {{$dailyInput->reportDate}}</td>
                                    <td>{{$dailyInput->timeFrom}}</td>
                                    <td>{{$dailyInput->timeUpto}}</td>
                                    <td>{{$dailyInput->timeTotal}}</td>
                                    <td>
                                        <ul class="list-inline">
                                            @if($dailyInput->reportDate == date('Y-m-d') || \Illuminate\Support\Facades\Auth::user()->role->id == 1)
                                            <li><a href="#" data-toggle="modal" data-target="#myModal2" onclick="edit_book({{$dailyInput->id}})" ><img src="{{asset('img/edit.png')}}" alt=""></a></li>
                                            @endif
                                            <li><a href="{{ URL::to('dailyInput/delete/'.$dailyInput->id) }}" onclick="return confirm('Are you sure you want to delete?')"><img src="{{asset('img/remove.png')}}" alt=""></a></li>
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

<!-- Modal --> <!--  for add daily input-->
<div class="modal fade modal-small" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span data-dismiss="modal" aria-label="Close" aria-hidden="true" class="closeFixed">&times;</span>
                <h2 class="modal-title" id="myModalLabel">Daily Input</h2>
            </div>
            <form class="form-signin" method="post" action="{{ URL::to('dailyInput_save') }}"  id="formFirst">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <label for="inputClient">Client</label>
                    <select name="inputClient" id="inputClient">
                        <option value="0">---Select---</option>
                        @if(isset($clients))
                            @foreach($clients as $client)
                                <option value="{{$client->id}}">{{$client->name}}</option>
                            @endforeach
                        @endif
                    </select>

                    <label for="inputStaffDetail">Staff</label>
@if(\Illuminate\Support\Facades\Auth::user()->role->id != 1)
                    <input type="text" name="inputStaffDetail" value="{{\Illuminate\Support\Facades\Auth::user()->name}}">
                    <input type="hidden" name="inputStaffDetailID" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
@else
                        <select name="inputStaffDetailID" id="inputStaffDetailID">
                            <option value="0">---Select---</option>
                            @if(isset($staffDetails))
                                @foreach($staffDetails as $staffDetail)
                                    <option value="{{$staffDetail->id}}">{{$staffDetail->name}}</option>
                                @endforeach
                            @endif
                        </select>
    @endif
                    <input type="text" name="inputTimeTotal" placeholder="Total Time HH:MM">

                    <label for="inputTimeFrom">Optional :Time from</label>
                    <input class="timepicker form-control" type="text" name="inputTimeFrom">

                    <label for="inputTimeUpto">Optional :time upto</label>
                    <input class="timepicker form-control" type="text"  name="inputTimeUpto">

                    <label for="inputReportDate">Date of report</label>
                    <input type="text" name="inputReportDate" class="datepick">
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-6 text-center">
                            <nput type="submit" name="Submit" value="Submit" >
                                <button type="type">submitt</button>
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


<!-- loop modal -->
<div class="modal fade modal-small" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span data-dismiss="modal" aria-label="Close" aria-hidden="true" class="closeFixed">�</span>
                <h2 class="modal-title" id="myModalLabel">Client Update</h2>
            </div>
            <form action="{{ url::to('dailyInput/update') }}" method="POST" id="form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <label for="inputClient">Client</label>
                    <select name="inputClient" id="inputClient">
                        <option value="0">---Select---</option>
                        @if(isset($clients))
                            @foreach($clients as $client)
                                <option value="{{$client->id}}">{{$client->name}}</option>
                            @endforeach
                        @endif
                    </select>

                    <label for="inputStaffDetail">Staff</label>
                    <select name="inputStaffDetail" id="inputStaffDetail">
                        <option value="0">---Select---</option>
                        @if(isset($staffDetails))
                            @foreach($staffDetails as $staffDetail)
                                <option value="{{$staffDetail->id}}">{{$staffDetail->name}}</option>
                            @endforeach
                        @endif
                    </select>

                    <input type="hidden" name="id">
                    <input type="text" name="inputTimeTotal" placeholder="Total Time HH:MM">

                    <label for="inputTimeFrom">Optional :Time from</label>
                    <input class="timepicker form-control" type="text" id="inputTimeFrom" name="inputTimeFrom">

                    <label for="inputTimeUpto">Optional :time upto</label>
                    <input class="timepicker form-control" type="text" id="inputTimeUpto" name="inputTimeUpto">

                    <label for="inputReportDate">Date of report</label>
                    <input type="text" name="inputReportDate" class="datepick">
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
                <span data-dismiss="modal" aria-label="Close" aria-hidden="true" class="closeFixed">�</span>
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
            url: "{{ URL::to('dailyInput')}}" +"/"+id+ '/edit/',
            type: "GET",
            dataType: "JSON",
            success: function (data) {

                console.log(data);
                $('[name="id"]').val(data.id);
                $('[name="inputClient"]').val(data.client_id);
                $('[name="inputStaffDetail"]').val(data.user_id);
                $('[name="inputTimeTotal"]').val(data.timeTotal);
                $('[name="inputTimeFrom"]').val(data.timeFrom);
                $('[name="inputTimeUpto"]').val(data.timeUpto);
                $('[name="inputReportDate"]').val(data.reportDate);

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