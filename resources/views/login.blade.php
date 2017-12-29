<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <title>login</title>
    <style>
        html,body{

        }
        #login_contaier{position: relative; height: 100%}
        #login{position: relative; }
        #login .nav-tabs li{width: 50%}
        .clock{text-align: center; margin-top: 0%}
        .logo {
            margin-top: 10%;
            margin-bottom: 5%;
        }
        .logo img{ height: 120px; width: auto; display: block; margin: 0 auto}
        #login .logo-main{margin-top: 15%;position: relative;z-index: 2; max-width:100%;height: auto}
        #login .nav-tabs > li > a{border-radius: 0; background: #1f2d5c; border: none; font-family: "Open Sans Bold"; color: #fff; font-size: 24px; text-align: center }
        #login .nav-tabs > li.active > a, #login .nav-tabs > li.active > a:focus, #login .nav-tabs > li.active > a:hover{background: #fff; color: #000}
        #login .nav-tabs > li > a:hover{background: #fff; color: #000}
        #login .tab-content {padding: 8% 22%;}
        #login .tab-content .tab-pane h1{margin-bottom: 3rem}
        #login .tab-content .tab-pane input{width: 100%; margin: 1rem 0 3rem 0}
        #login .tab-content .tab-pane .checbox { margin-bottom: 2rem}
        #login .tab-content .tab-pane .checbox label{font-family: "Open Sans Light"; font-weight: normal}
        #login .tab-content .tab-pane .checbox input{width: initial; margin: 0}
        #login .tab-content .tab-pane  button{height: 40px; min-width: 115px;font-family: "Open Sans Bold";font-size: 14px;}
        .tab-footer {
            margin-top: 5rem;
        }
        .tab-footer{margin-bottom: 0}
        #footer_login{background: #1f2d5c; color: #fff; position: relative; width: 100%; text-align: center}
        #footer_login span{width: 100%; display: block;line-height: 55px; }
        svg{height: 150px}
        #face { stroke-width: 1px; stroke: #fff; fill: transparent }
        #hour, #min, #sec {
            stroke-width: 1px;
            fill: #000;
        }
        #sec { stroke: #f55; }

        @media (min-width: 768px) {
            #login:before{position: absolute; content: '';  background: url("img/timesheet.jpg") no-repeat center center #000; width: 50%; left: 0; top: 0; height: 100%}
            #footer_login .DAndD {
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
            }
            /*#login{position: relative; height: calc(100vh - 55px)}*/
            .bg_trans{height: calc(100vh - 55px); position: relative}
            .bg_trans:before{content: '';position: absolute; left: 0; right: 0; top: 0; bottom: 0;    background: rgba(195, 195, 195, 0.31); z-index: 1; height: 100%; width: 100%}
        }
        @media (max-width: 767px) {
            #login .logo-main {
                margin-top: 2rem;
                position: relative;
                z-index: 2;
                margin-bottom: 5rem;
                height: 50px;
                width: auto;
            }
            .clock{margin-bottom: 5rem}
            #face{
                stroke: #000;
            }
        }
    </style>
</head>
<body>
<div id="login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 bg_trans">
                <img src="{{asset('img/logo.jpg')}} " style="height: 55px; float: left" alt="">
                <div class="logo">

                    <img src="{{asset('img/Logo-Design_01.png')}} " alt="" >

                </div>
                <div style="clear: both"></div>
                <div class="clock" id="clock">

                    <svg id="clock" viewBox="0 0 100 100">
                        <circle id="face" cx="50" cy="50" r="45"/>
                        <g id="hands">
                            <rect id="hour" x="47.5" y="12.5" width="5" height="40" rx="2.5" ry="2.55"/>
                            <rect id="min" x="48.5" y="12.5" width="3" height="40" rx="2" ry="2"/>
                            <line id="sec" x1="50" y1="50" x2="50" y2="16"/>
                        </g>
                    </svg>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="row">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab"
                                                                  data-toggle="tab">Login</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                                                   data-toggle="tab">Signup</a></li>
                    </ul>
                    <!-- to print message -->
                    {{--@if(!empty($message))--}}
                        {{--<p>{{$message}}</p>--}}
                        {{--@elseif()--}}

                    @if (session('message'))
                        <p>{{ session('message') }}</p>
                        @endif
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <form action="{{ route('login') }}" method="post">
                                {{ csrf_field() }}
                                <div class="">
                                    <h1>Login</h1>

                                    {{--<input type="text" placeholder="Staff Name">--}}
                                    <input type="email" id="email" name="email" placeholder="Email">
                                    <input type="password" id="password" name="password" placeholder="Passwod">
                                    <div class="checbox">
                                        <label for="">
                                            <input type="checkbox">
                                            I agree to the terms
                                        </label>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit">Login</button>
                                    </div>
                                </div>
                            </form>
                            <div class="tab-footer">
                                <p>Login with social media</p>
                                <ul class="list-inline">
                                    <li><a href=""><img src="{{asset('img/fb.png')}}" alt=""></a></li>
                                    <li><a href=""><img src="{{asset('img/twitter.png')}}" alt=""></a></li>
                                    <li><a href=""><img src="{{asset('img/gplus.jpg')}}" alt=""></a></li>
                                </ul>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">

                            @if (session('message'))
                                <p>{{ session('message') }}</p>
                            @endif
                            <form action="{{ route('register') }}" method="POST">
                                    {{ csrf_field() }}
                                <div class="">
                                    <h1>Create Account</h1>
                                    <p>Dont have account? Create your account,it takes <br>
                                        less than a minute</p>
                                    <input type="text" id="name" name="name" placeholder="Staff Name">
                                    <input type="email" id="email" name="email" placeholder="Email">
                                    <input type="password" id="password" name="password" placeholder="Passwod">
                                    <input type="password" id="password-confirm" name="password_confirmation" placeholder="Re-Passwod">
                                    <div class="checbox">
                                        <label for="">
                                            <input type="checkbox">
                                            I agree to the terms
                                        </label>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit">Register</button>
                                    </div>
                                </div>
                                <div class="tab-footer">
                                    <p>Login with social media</p>
                                    <ul class="list-inline">
                                        <li><a href=""><img src="{{asset('img/fb.png')}}" alt=""></a></li>
                                        <li><a href=""><img src="{{asset('img/twitter.jpg')}}" alt=""></a></li>
                                        <li><a href=""><img src="{{asset('img/gplus.jpg')}}" alt=""></a></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
{{isset($success)?$success:'not'}}
<footer id="footer_login">
    <div class="foot-content">
        <div class="text-center">
            <span>&copy;2016 Company name All rights reserved.</span>
        </div>
        <div class="DAndD">
            <span>Designed and developed by <img src="{{asset('img/wiz-logo.png')}}" alt=""></span>
        </div>
    </div>
</footer>



<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>

<script>
    setInterval(function() {
        function r(el, deg) {
            el.setAttribute('transform', 'rotate('+ deg +' 50 50)')
        }
        var d = new Date()
        r(sec, 6*d.getSeconds())
        r(min, 6*d.getMinutes())
        r(hour, 30*(d.getHours()%12) + d.getMinutes()/2)
    }, 1000)

</script>


</body>
</html>