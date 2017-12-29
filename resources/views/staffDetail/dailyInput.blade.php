
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
                        <li><a href="{{ URL::to('client') }}">Clients </a></li>
                        <li><a href="{{ URL::to('staffDetail') }}">Staff </a></li>
                        <li><a href="{{ URL::to('task') }}">Task </a></li>
                        <li><a href="{{ URL::to('designation') }}">Designation </a></li>
                        <li><a href="{{ URL::to('charge') }}">Charges </a></li>
                        <li class="active"><a href="{{ URL::to('dailyInput') }}">DailyInputs </a></li>
                        <li><a href="{{ URL::to('admin') }}">Admin </a></li>
                    </ul>
                </nav>
            </div>
            <div class="rightNav">
                <a href="#">Login</a>
            </div>
        </div>
    </div>
</header>
<section class="main">
    <div class="container">
        <h2 class="heading-main">Daily Input<span class="addIcon" data-toggle="modal" data-target="#myModal" onclick="$('#formFirst')[0].reset();"><i><img
                            src="img/add.png" alt=""></i>Add</span></h2>

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
                                    <td>{{$dailyInput->client->name}}</td>
                                    <td>{{$dailyInput->staffDetail->name}}</td>
                                    <td>{{$dailyInput->reportDate}}</td>
                                    <td>{{$dailyInput->timeFrom}}</td>
                                    <td>{{$dailyInput->timeUpto}}</td>
                                    <td>{{$dailyInput->timeTotal}}</td>
                                    <td>
                                        <ul class="list-inline">
                                            <li><a href="#" data-toggle="modal" data-target="#myModal2" onclick="edit_book({{$dailyInput->id}})" ><img src="{{asset('img/edit.png')}}" alt=""></a></li>
                                            <li><a href="{{ URL::to('dailyInput/delete/'.$dailyInput->id) }}"><img src="{{asset('img/remove.png')}}" alt=""></a></li>
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
                <h2 class="modal-title" id="myModalLabel">Daily Input</h2>
            </div>
            <form class="form-signin" method="post" action="{{ URL::to('dailyInput') }}"  id="formFirst">
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
                    <select name="inputStaffDetail" id="inputStaffDetail">
                        <option value="0">---Select---</option>
                        @if(isset($staffDetails))
                            @foreach($staffDetails as $staffDetail)
                                <option value="{{$staffDetail->id}}">{{$staffDetail->name}}</option>
                            @endforeach
                        @endif
                    </select>


                    <input type="text" name="inputTimeTotal" placeholder="Total Time HH:MM">

                    <label for="inputTimeFrom">Optional :Time from</label>
                    <input class="timepicker form-control" type="text" id="inputTimeFrom" name="inputTimeFrom">

                    <label for="inputTimeUpto">Optional :time upto</label>
                    <input class="timepicker form-control" type="text" id="inputTimeUpto" name="inputTimeUpto">

                    <label for="inputReportDate">Date of report</label>
                    <input type="date" name="inputReportDate" class="datepick" placeholder="valid upto">
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


<!-- loop modal -->
<div class="modal fade modal-small" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span data-dismiss="modal" aria-label="Close" aria-hidden="true" class="closeFixed">×</span>
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
                    <input type="date" name="inputReportDate" class="datepick" placeholder="valid upto">
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
                $('[name="inputStaffDetail"]').val(data.staff_detail_id);
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