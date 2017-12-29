<!doctype html>



<html lang="en">



<head>



    <title>All Detials</title>





    <!-- Required meta tags -->



    <meta charset="utf-8">



    <meta name="csrf-token" content="{{ csrf_token() }}"/>



    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">





    <!-- Bootstrap CSS -->



    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}} "/>



    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.min.css')}} "/>



    <link rel="stylesheet" href="{{asset('css/style.css')}} "/>





    <script src="{{asset('js/jquery-3.2.1.min.js')}} "></script>



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



                        <li><a href="{{ URL::to('charge') }}">Charges </a></li>



                        <li><a href="{{ URL::to('dailyInput') }}">DailyInputs </a></li>



                        <li class="active"><a href="{{ URL::to('admin') }}">Details </a></li>

                        <li ><a href="{{ URL::to('report/pie') }}">Report </a></li>



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



        <h2 class="heading-main">Admin </h2>



        {{--<span class="addIcon" data-toggle="modal" data-target="#myModal"><i><img src="{{asset('img/add.png')}}" alt=""></i>Add</span>--}}



        <div class="row">



            <form method="post" action="{{ URL::to('admin') }}">



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



                </div>



            </form>



        </div>



        <div class="row">



            <div class="col-sm-12">



                <div class="main-table">



                    <table class="table">



                        <thead>



                        <tr>



                            <th>Date</th>



                            <th>Client</th>



                            <th>Staff</th>



                            <th>Designation</th>



                            <th>Hours</th>



                            <th>Rate</th>



                            <th>Amount</th>



                        </tr>



                        </thead>



                        <tbody>



                        <?php $ttime = 0; $trate = 0; $ttotal = 0;?>



                        @if(isset($dailyInputs))



                            @foreach($dailyInputs as $dailyInput)



                                <?php $rate = isset($dailyInput->user->designation) ? (isset($dailyInput->user->designation->charge) ? (isset($dailyInput->user->designation->charge->last()->rate) ? $dailyInput->user->designation->charge->last()->rate : 0) : 0) : 0 ?>



                                <tr>



                                    <td>{{$dailyInput->reportDate}}</td>



                                    <td>{{$dailyInput->client->name}}</td>



                                    <td>{{$dailyInput->user->name}}</td>



                                    <td>{{isset($dailyInput->user->designation)?$dailyInput->user->designation->title:''}}</td>



                                    <td>{{$dailyInput->timeTotal}}</td>



                                    <td>{{$rate}}</td>







                                    <?php $HRS = date('H', strtotime($dailyInput->timeTotal)) . '.' . date('i', strtotime($dailyInput->timeTotal));  ?>



                                    <?php $ttime += $dailyInput->timeTotal;?>



                                    <?php $trate += $rate;?>



                                    <?php $ttotal += $HRS * $rate;?>



                                    <td>{{$HRS * $rate}}</td>





                                </tr>



                            @endforeach



                        @endif



                        </tbody>



                        <tfoot>



                        <tr>



                            <td colspan="4" align="right"><strong>Total</strong></td>





                            <td>{{$ttime}}</td>



                            <td>{{($ttime != '0') ? number_format($ttotal/$ttime, 2) : '0'}}</td>



                            <td>{{$ttotal}}</td>



                        </tr>



                        </tfoot>



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



                <h2 class="modal-title" id="myModalLabel">Client Detail</h2>



            </div>



            <div class="modal-body">



                <input type="text" placeholder="Name">



                <input type="text" placeholder="Address">



                <input type="text" placeholder="Phone Number">



                <input type="text" placeholder="Contact Person">



                <input type="text" placeholder="Mobile Number">



                <input type="text" placeholder="NTN">



                <div class="fieldWithLabel">



                    <label for="">Joining Date</label>



                    <input type="text" placeholder="NTN">



                </div>



                <div class="fieldWithLabel">



                    <label for="">Date Picker</label>



                    <input type="text" class="datepick" placeholder="NTN">



                </div>



                <div class="fieldWithLabel">



                    <input type="text" placeholder="NTN">



                </div>



                <div class="fieldWithLabel">



                    <input type="text" placeholder="NTN">



                </div>



                <div class="fieldWithLabel Cell">



                    <label for="">Joining Date</label>



                    <select name="" id="">



                        <option value="">---Select---</option>



                    </select>



                </div>



            </div>



            <div class="modal-footer">



                <div class="row">



                    <div class="col-xs-6 text-center">



                        <button type="button" data-dismiss="modal">Submit</button>



                    </div>



                    <div class="col-xs-6 text-center">



                        <button type="button">Exit</button>



                    </div>



                </div>



            </div>



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



<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>



<script src="{{asset('js/bootstrap.min.js')}}"></script>



<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>



<script>



    $(document).ready(function () {



        $(".datepick").datepicker({format: 'yyyy-mm-dd'});



    })



</script>



</body>



</html>