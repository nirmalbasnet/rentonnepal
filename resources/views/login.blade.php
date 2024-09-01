<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config("constants.APP_NAME")}} | Login</title>

    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}"/>
    <link rel="stylesheet" href="{{asset("assets/bootstrap/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/css/my-style.css")}}">
    <link rel="stylesheet" href="{{asset("assets/fontawesome/css/all.css")}}">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300;400;700&display=swap");

        body {
            font-size: 1rem;
            font-family: 'Kumbh Sans', sans-serif;
            font-weight: initial;
            line-height: normal;
            -webkit-font-smoothing: antialiased;
            -moz-font-smoothing: antialiased;
            -ms-font-smoothing: antialiased;
            -o-font-smoothing: antialiased;
            background-color: #fff;
        }

        /* Set a style for all buttons */
        button.login {
            /*background-color: #77B852;*/
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        /*button.login:hover {*/
        /*opacity: 0.8;*/
        /*}*/

        /* Extra styles for the cancel button */
        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }

        /* Center the image and position the close button */
        .imgcontainer {
            text-align: center;
            margin: 24px 0 0;
            position: relative;
        }

        img.avatar {
            width: 40%;
            border-radius: 50%;
        }

        .container {
            padding: 16px;
        }

        span.psw {
            float: right;
            padding-top: 16px;
        }

        /* The Mod (background) */
        .mod {
            position: absolute;
            z-index: 1;
            left: 0;
            top: 50%;
            width: 100%;
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            transform: translateY(-50%);
        }

        /* Mod Content/Box */
        .mod-content {
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
            margin: 0 auto; /* 5% from the top, 15% from the bottom and centered */
            /*border: 1px solid #888;*/
            width: 30%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button (x) */
        /*.close {*/
        /*position: absolute;*/
        /*right: 25px;*/
        /*top: 0;*/
        /*color: #000;*/
        /*font-size: 35px;*/
        /*font-weight: bold;*/
        /*}*/

        /*.close:hover,*/
        /*.close:focus {*/
        /*color: red;*/
        /*cursor: pointer;*/
        /*}*/

        /* Add Zoom Animation */
        .animate {
            -webkit-animation: animatezoom 0.6s;
            -moz-animation: animatezoom 0.6s;
            -ms-animation: animatezoom 0.6s;
            -o-animation: animatezoom 0.6s;
            animation: animatezoom 0.6s
        }

        @-webkit-keyframes animatezoom {
            from {
                -webkit-transform: scale(0);
            }
            to {
                -webkit-transform: scale(1);
            }
        }

        @-moz-keyframes animatezoom {
            from {
                -moz-transform: scale(0);
            }
            to {
                -moz-transform: scale(1);
            }
        }

        @-ms-keyframes animatezoom {
            from {
                -ms-transform: scale(0);
            }
            to {
                -ms-transform: scale(1);
            }
        }

        @-o-keyframes animatezoom {
            from {
                -o-transform: scale(0);
            }
            to {
                -o-transform: scale(1);
            }
        }

        @keyframes animatezoom {
            from {
                transform: scale(0)
            }
            to {
                transform: scale(1)
            }
        }

        /*body{*/
        /*background: #84BF65;*/
        /*}*/

        form {
            color: #000;
        }

        .login-content {
            width: 90%;
            margin: 0 auto;
        }

        .bottom-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .text-center {
            text-align: center;
        }

        .register-here {
            /*margin-bottom: 20px;*/
        }

        .bottom-section a, .register-here a {
            color: #fff;
            text-decoration: none;
        }

        .register-here a {
            font-weight: 600;
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }

            .cancelbtn {
                width: 100%;
            }
        }

        @media (max-width: 1150px) {
            .mod-content {
                width: 35%;
            }
        }

        @media (max-width: 980px) {
            .mod-content {
                width: 40%;
            }
        }

        @media (max-width: 855px) {
            .mod-content {
                width: 45%;
            }
        }

        @media (max-width: 765px) {
            .mod-content {
                width: 60%;
            }
        }

        @media (max-width: 562px) {
            .mod-content {
                width: 90%;
            }
        }

        form {
            padding-top: 5px;
            padding-bottom: 15px;
        }

        form label {
            margin-top: 10px;
            margin-bottom: 8px;
        }

        .or-overlay {
            top: 0;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 0 10px;
            background: #fff;
            color: #bbb;
        }

        .reg-btn{
            background: #FF9933;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            transition-property: color, background-color, border-color, box-shadow;
            transition-duration: 0.15s, 0.15s, 0.15s, 0.15s;
            transition-timing-function: ease-in-out, ease-in-out, ease-in-out, ease-in-out;
            transition-delay: 0s, 0s, 0s, 0s;
            font-weight: 600;
        }

        .reg-btn:hover, .reg-btn:focus{
            background-color: #ff860d;
            border-color: #ff8000;
            outline: none;
            color: #000;
        }
    </style>
</head>
<body>

<div id="id01" class="mod">

    <form class="mod-content animate" action="{{url("admin/login")}}" method="post">
        @csrf
        <div class="imgcontainer">
            <a href="{{url("/")}}"><img src="{{asset("assets/images/form-logo.png")}}" alt="RentOnNepal Logo"></a>
        </div>


        <div class="container">
            {{--<div class="social-login mt-2">--}}
                {{--<p class="text-center">Log in with your social media account</p>--}}
                {{--<div class="row">--}}
                    {{--<div class="col-12">--}}
                        {{--<div class="google-login text-center mb-2">--}}
                            {{--<a href="{{url("google/login")}}">--}}
                                {{--<img class="img-fluid" src="{{asset("assets/images/gmail-login.png")}}"--}}
                                     {{--alt="login with gmail">--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col-12">--}}
                        {{--<div class="fb-login text-center">--}}
                            {{--<a href="{{url("facebook/login")}}">--}}
                                {{--<img class="img-fluid" src="{{asset("assets/images/fb-login.png")}}"--}}
                                     {{--alt="login with facebook">--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="position-relative">--}}
                    {{--<hr style="margin-top: 2rem;">--}}
                    {{--<strong class="position-absolute or-overlay">--}}
                        {{--or--}}
                    {{--</strong>--}}
                {{--</div>--}}
            {{--</div>--}}

            @include("partials.flash.flash")
            <div class="login-content">
                <div class="form-group">
                    <label class="" for="email">Email</label>
                    <input value="{{old("email")}}" class="form-control" type="email" placeholder="example@example.com"
                           name="email" required>
                    @error('email')
                    <span class="form-validation-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="" for="password">Password</label>
                    <input class="form-control" type="password" placeholder="******" name="password" required>
                    @error('password')
                    <span class="form-validation-error">{{ $message }}</span>
                    @enderror
                </div>

                <button class="login btn reg-btn" type="submit">Login</button>

                <div class="bottom-section">
                    <label>
                        <input type="checkbox" name="remember"> Keep me signed in
                    </label>

                    {{--<span><a style="color: darkblue; font-weight: 300;"--}}
                    {{--href="{{url("lost-password")}}">Lost password ?</a></span>--}}
                </div>

                {{--<div class="register-here-section">--}}
                    {{--<span style="font-weight: 300;">Don't have an account ?--}}
                        {{--<a style="color: darkblue; font-weight: 300;"--}}
                           {{--href="{{url("register")}}">Register Now</a></span>--}}
                {{--</div>--}}
            </div>
        </div>
    </form>

    @if(!\Illuminate\Support\Facades\Request::is("dashboard/profile/edit") && \Illuminate\Support\Facades\Session::has("postData"))
        @php \Illuminate\Support\Facades\Session::forget("postData"); @endphp
    @endif
</div>

<script src="{{asset("assets/jquery-slim.js")}}"></script>
<script src="{{asset("assets/popper.min.js")}}"></script>
<script src="{{asset("assets/bootstrap/js/bootstrap.min.js")}}"></script>

</body>
</html>