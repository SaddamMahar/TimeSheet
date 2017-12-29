
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
                        <li class="active"><a href="{{ URL::to('staffDetail') }}">Staff </a></li>
                        <li><a href="{{ URL::to('task') }}">Task </a></li>
                        <li><a href="{{ URL::to('designation') }}">Designation </a></li>
                        <li><a href="{{ URL::to('charge') }}">Charges </a></li>
                        <li><a href="{{ URL::to('dailyInput') }}">DailyInputs </a></li>
                        <li ><a href="{{ URL::to('admin') }}">Details </a></li>
                        <li ><a href="{{ URL::to('report/pie') }}">Report </a></li>

                    </ul>
                </nav>
            </div>
            <div class="rightNav">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
</header>
<section class="main">
    <div class="container">
        <h2 class="heading-main">Staff Detail <span class="addIcon" data-toggle="modal" data-target="#myModal" onclick="$('#formFirst')[0].reset();"><i><img src="img/add.png" alt=""></i>Add</span></h2>
        <div class="row">
            <div class="col-sm-12">
                <div class="main-table">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Email</th>
                            <th>Active</th>
                            <th>Joining Date</th>
                            <th>Leaving Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($staffDetails))
                            @foreach($staffDetails as $staffDetail)
                                <tr>
                                    <td>{{$staffDetail->name}}</td>
                                    <td>{{isset($staffDetail->designation->title)?$staffDetail->designation->title:''}}</td>
                                    <td>{{$staffDetail->email}}</td>
                                    <td>
                                        <input id="toggle-one" type="checkbox" name="toggle-one" <?php if($staffDetail->active == '1'){echo'checked="checked"';};?> onclick="updateActive({{$staffDetail->id}})"> </td>
                                    <td>{{$staffDetail->joiningDate}}</td>
                                    <td>{{$staffDetail->leavingDate}}</td>
                                    <td>
                                        <ul class="list-inline">
                                            <li><a href="#" data-toggle="modal" data-target="#myModal2" onclick="edit_book({{$staffDetail->id}})"><img src="{{asset('img/edit.png')}}" alt=""></a></li>
                                            <li><a href="{{ URL::to('staffDetail/delete/'.$staffDetail->id) }}"><img src="{{asset('img/remove.png')}}" alt=""></a></li>
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
                <h2 class="modal-title" id="myModalLabel">Staff Detail</h2>
            </div>
            <form class="form-signin" method="post" action="{{ URL::to('staffDetail') }}" id="formFirst">
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
                <input type="text" name="inputName" placeholder="Name">
                <input type="email" name="inputEmail" placeholder="Email">
                {{--<input type="password" name="inputPassword" placeholder="Password">--}}
                <input type="date" name="inputJoiningDate" class="datepick" placeholder="Joining date">
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <button type="submit">Submit</button>
                    </div>
                    <div class="col-sm-6 text-center">
                        <button type="button"  data-dismiss="modal">Exit</button>
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
            <form action="{{ url::to('staffDetail/update') }}" method="POST" id="form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <label for="inputDesignation">Designation</label>
                    <select name="inputDesignation" id="inputDesignation">
                        <option value="0">---Select---</option>
                        @if(isset($designations))
                            @foreach($designations as $designation)
                                <option value="{{$designation->id}}">{{$designation->title}}</option>
                            @endforeach
                        @endif
                    </select>
                    <input type="text" name="inputName" placeholder="Name">
                    <input type="email" name="inputEmail" placeholder="Email">
                    {{--<input type="password" name="inputPassword" placeholder="Password">--}}
                    <input type="date" name="inputJoiningDate" class="datepick" placeholder="Joining date">
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-6 text-center">
                            <button type="submit" >Submit</button>
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
    $(function() {
        $('#toggle-one').bootstrapToggle();
    })

    function edit_book(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        var uri = '{{URL::to('/')}}';
        //Ajax Load data from ajax
        $.ajax({
            url: "{{ URL::to('staffDetail')}}" +"/"+id+ '/edit/',
            type: "GET",
            dataType: "JSON",
            success: function (data) {

                console.log(data);
                $('[name="id"]').val(data.id);
                $('[name="inputDesignation"]').val(data.designation_id);
                $('[name="inputName"]').val(data.name);
                $('[name="inputEmail"]').val(data.email);
                $('[name="inputPassword"]').val(data.password);
                $('[name="inputContact"]').val(data.contact);
                $('[name="inputJoiningDate"]').val(data.joiningDate);
                $('[name="inputLeavingDate"]').val(data.leavingDate);
//                $('[name="inputnic"]').val(data.nic);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    $(document).ready(function () {
        $(".datepick").datepicker({format: 'yyyy-mm-dd'});
//        $('#toggle-one').change
    })

    function updateActive(id) {
        var uri = '{{URL::to('/')}}';
        //Ajax Load data from ajax
        $.ajax({
            url: "{{ URL::to('staffDetail/update/active')}}" +"/"+id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                alert(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }
</script>
</body>
</html>