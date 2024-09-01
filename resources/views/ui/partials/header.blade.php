<!--header-->
<header id="site-header" class="fixed-top nav-fixed">
    <div class="container">
        <nav class="navbar navbar-expand-lg stroke px-0">
            <h1>
                <a style="background: #fff; padding: 5px;" class="navbar-brand" href="{{url("/")}}">
                    <img src="{{asset('assets/images/no-bg-nav-logo.png')}}" class="img-fluid" alt="Rent on nepal logo">
                </a>
            </h1>

            <button class="navbar-toggler  collapsed bg-gradient" type="button" data-toggle="collapse"
                    data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fa icon-expand fa-bars"></span>
                <span class="navbar-toggler-icon fa icon-close fa-times"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav ml-lg-5 mr-auto">
                    <li class="nav-item {{\Illuminate\Support\Facades\Request::is("/") ? 'active' : ''}}">
                        <a class="nav-link" href="{{url("/")}}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item  {{\Illuminate\Support\Facades\Request::is("properties") ? 'active' : ''}}">
                        <a class="nav-link" href="{{url("properties")}}">Properties</a>
                    </li>
                    {{--<li class="nav-item  {{\Illuminate\Support\Facades\Request::is("services") ? 'active' : ''}}">--}}
                    {{--<a class="nav-link" href="{{url("services")}}">Services</a>--}}
                    {{--</li>--}}
                    <li class="nav-item  {{\Illuminate\Support\Facades\Request::is("agents") ? 'active' : ''}}">
                        <a class="nav-link" href="{{url("agents")}}">Agents</a>
                    </li>
                    <li class="nav-item  {{\Illuminate\Support\Facades\Request::is("contact") ? 'active' : ''}}">
                        <a class="nav-link" href="{{url("contact")}}">Contact</a>
                    </li>
                    <li class="nav-item  {{\Illuminate\Support\Facades\Request::is("privacy") ? 'active' : ''}}">
                        <a class="nav-link" href="{{url("privacy")}}">Privacy</a>
                    </li>

                    @if(\Illuminate\Support\Facades\Auth::guest())
                        <li class="nav-item d-lg-none  {{\Illuminate\Support\Facades\Request::is("become-agent") ? 'active' : ''}}">
                            <a class="nav-link" href="{{url("become-agent")}}">Become Agent</a>
                        </li>

                        <li class="nav-item d-lg-none  {{\Illuminate\Support\Facades\Request::is("login") ? 'active' : ''}}">
                            <a class="nav-link" href="{{url("login")}}">Post Property</a>
                        </li>
                    @else
                        <li class="nav-item d-lg-none  {{\Illuminate\Support\Facades\Request::is("dashboard") ? 'active' : ''}}">
                            <a class="nav-link" href="{{url("dashboard")}}">Dashboard</a>
                        </li>
                    @endif
                </ul>

                @if(\Illuminate\Support\Facades\Auth::guest())
                    <div class="top-quote mt-lg-0 mr-3 d-none d-lg-block">
                        <a href="{{url("become-agent")}}"
                           class="btn btn-style btn-primary {{\Illuminate\Support\Facades\Request::is('become-agent') ? 'active-button' : ''}}">
                            Become Agent
                        </a>
                    </div>

                    <div class="top-quote mt-lg-0 d-none d-lg-block">
                        <a href="{{url("login")}}"
                           class="btn btn-style btn-primary {{\Illuminate\Support\Facades\Request::is('login') ? 'active-button' : ''}}">
                            Post Property
                        </a>
                    </div>
                @else
                    @if(\Illuminate\Support\Facades\Auth::user()->user_type === "tenant")
                        <div class="top-quote mt-lg-0 mr-3 d-none d-lg-block">
                            <a href="{{url("become-agent")}}" class="btn btn-style btn-primary {{\Illuminate\Support\Facades\Request::is('become-agent') ? 'active-button' : ''}}">
                                Become Agent
                            </a>
                        </div>
                    @endif
                    <div class="top-quote mt-lg-0 d-none d-lg-block">
                        <a href="{{url("dashboard")}}" class="btn btn-style btn-primary">
                            Dashboard
                        </a>
                    </div>
            @endif
            <!--/search-right-->
            {{--<div class="search mx-3">--}}
            {{--<input class="search_box" type="checkbox" id="search_box">--}}
            {{--<label class="fa fa-search" for="search_box"></label>--}}
            {{--<div class="search_form">--}}
            {{--<form action="error.html" method="GET">--}}
            {{--<input type="text" placeholder="Search"><input type="submit" value="search">--}}
            {{--</form>--}}
            {{--</div>--}}
            {{--</div>--}}
            <!--//search-right-->
            </div>

            <!-- toggle switch for light and dark theme -->
        {{--<div class="mobile-position">--}}
        {{--<nav class="navigation">--}}
        {{--<div class="theme-switch-wrapper">--}}
        {{--<label class="theme-switch" for="checkbox">--}}
        {{--<input type="checkbox" id="checkbox">--}}
        {{--<div class="mode-container">--}}
        {{--<i class="gg-sun"></i>--}}
        {{--<i class="gg-moon"></i>--}}
        {{--</div>--}}
        {{--</label>--}}
        {{--</div>--}}
        {{--</nav>--}}
        {{--</div>--}}
        <!-- //toggle switch for light and dark theme -->
        </nav>
    </div>
</header>