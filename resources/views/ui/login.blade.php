@extends("ui.master")

@section("title")
    Login
@stop

@section("style")
    <style>
        .mod {
            padding-top: 5rem;
            padding-bottom: 5rem;
        }

        /* Mod Content/Box */
        .mod-content {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
            margin: 0 auto;
            background: #fff;
            padding: 5rem;
            width: 50%;
        }

        @media (max-width: 1199px) {
            .mod-content {
                width: 60%;
            }
        }

        @media (max-width: 991px) {
            .mod-content {
                width: 90%;
            }

            .mod {
                padding-top: 8rem;
            }
        }

        @media (max-width: 767px) {
            .mod-content {
                width: 100%;
                padding-right: 2rem;
                padding-left: 2rem;
            }

            .mod {
                padding-top: 9rem;
            }
        }

        @media (max-width: 534px) {
            .mod-content {
                width: 100%;
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
@stop

@section("body")
    <section class="w3l-contact-7 pt-5" id="contact">
        <div class="contacts-9 pt-lg-5 pt-md-4">
            <div class="container">
                <div class="top-map">
                    <div id="id01" class="mod">
                        <form class="mod-content animate" action="{{url("login")}}" method="post">
                            @csrf
                            <div class="imgcontainer">

                            </div>

                            @include("partials.flash.flash")

                            @if(isset($_GET['agent-rating']))
                                @php
                                    \Illuminate\Support\Facades\Session::put('agent-rating-flash', \Illuminate\Support\Facades\URL::previous());
                                @endphp
                            @endif


                            <div class="container">
                                <div class="social-login mt-2">
                                    <p class="text-center">Log in with your</p>
                                    <h5 class="text-center" style="text-transform: uppercase; font-weight: 600;">social
                                        media account</h5>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="google-login text-center mb-2">
                                                <a href="{{\Illuminate\Support\Facades\Request::is('become-agent') ? url('agent/google/login') : url("google/login")}}">
                                                    <img class="img-fluid"
                                                         src="{{asset("assets/images/gmail-login.png")}}"
                                                         alt="login with gmail">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="fb-login text-center">
                                                <a href="{{\Illuminate\Support\Facades\Request::is('become-agent') ? url('agent/facebook/login') : url("facebook/login")}}">
                                                    <img class="img-fluid" src="{{asset("assets/images/fb-login.png")}}"
                                                         alt="login with facebook">
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    {{--<div class="position-relative">--}}
                                    {{--<hr style="margin-top: 2rem;">--}}
                                    {{--<strong class="position-absolute or-overlay">--}}
                                    {{--or--}}
                                    {{--</strong>--}}
                                    {{--</div>--}}
                                </div>


                                {{--<div class="login-content">--}}
                                {{--<div class="form-group">--}}
                                {{--<label class="" for="email">Email</label>--}}
                                {{--<input value="{{old("email")}}" class="form-control" type="email" placeholder="example@example.com"--}}
                                {{--name="email" required>--}}
                                {{--@error('email')--}}
                                {{--<span class="form-validation-error">{{ $message }}</span>--}}
                                {{--@enderror--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                {{--<label class="" for="password">Password</label>--}}
                                {{--<input class="form-control" type="password" placeholder="******" name="password" required>--}}
                                {{--@error('password')--}}
                                {{--<span class="form-validation-error">{{ $message }}</span>--}}
                                {{--@enderror--}}
                                {{--</div>--}}

                                {{--<button class="login btn reg-btn" type="submit">Login</button>--}}

                                {{--<div class="bottom-section">--}}
                                {{--<label>--}}
                                {{--<input type="checkbox" name="remember"> Keep me signed in--}}
                                {{--</label>--}}

                                {{--<span><a style="color: darkblue; font-weight: 300;"--}}
                                {{--href="{{url("lost-password")}}">Lost password ?</a></span>--}}
                                {{--</div>--}}

                                {{--<div class="register-here-section">--}}
                                {{--<span style="font-weight: 300;">Don't have an account ?--}}
                                {{--<a style="color: darkblue; font-weight: 300;"--}}
                                {{--href="{{url("register")}}">Register Now</a></span>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script>
        toastr.options.positionClass = "toast-bottom-right";

        @if(\Illuminate\Support\Facades\Session::has("agent_rating_data_status"))
        toastr.info("{{\Illuminate\Support\Facades\Session::get("agent_rating_data_status")}}");
        @endif
    </script>
@stop