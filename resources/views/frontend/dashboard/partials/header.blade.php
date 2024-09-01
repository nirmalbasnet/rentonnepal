<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
            <a class="navbar-brand brand-logo" href="{{url("dashboard")}}"><img class="img-fluid"
                                                                                style="max-width: 55% !important; height: auto;"
                                                                                src="{{asset('assets/images/nav-logo.png')}}"
                                                                                alt="Logo"/></a>
            <a class="navbar-brand brand-logo-mini" href="{{url("dashboard")}}"><img style="height: unset !important;"
                                                                                     src="{{asset('assets/images/nav-logo.png')}}"
                                                                                     alt="Logo"/></a>
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-sort-variant"></span>
            </button>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-4 w-100">
            <li class="nav-item nav-search d-none d-sm-block w-100 allow-notification-header-info">

            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="{{asset(\Illuminate\Support\Facades\Auth::user()->profile_pic ? \Illuminate\Support\Facades\Auth::user()->profile_pic : "assets/images/default-pp.png")}}" alt="profile"/>
                    <span class="nav-profile-name">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{url("/")}}">
                        <i class="mdi mdi-arrow-left-bold text-primary"></i>
                        Go To Home
                    </a>

                    <a class="dropdown-item" href="{{url("dashboard/profile")}}">
                        <i class="mdi mdi-account text-primary"></i>
                        Profile
                    </a>

                    <a class="dropdown-item" href="{{url("logout")}}">
                        <i class="mdi mdi-logout text-primary"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>