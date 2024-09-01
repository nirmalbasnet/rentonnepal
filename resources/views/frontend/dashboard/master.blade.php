<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config("constants.APP_NAME")}} | @yield('title')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset("assets/vendors/mdi/css/materialdesignicons.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/vendors/base/vendor.bundle.base.css")}}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{asset("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css")}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset("assets/css/style.css")}}">

    {{--<link rel="stylesheet" href="{{asset("assets/bootstrap/css/bootstrap-select.min.css")}}">--}}
    {{--<link rel="stylesheet" href="{{asset("assets/css/my-style.css")}}">--}}
    <link rel="stylesheet" href="{{asset("assets/fontawesome/css/all.css")}}">

    <link rel="stylesheet" href="{{asset("assets/css/my-style.css")}}">
    <link rel="stylesheet" href="{{asset("assets/alertify/css/alertify.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/flatpickr/flatpickr.min.css")}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}"/>

    <style>
        div.ajs-header {
            display: none !important;
        }

        @media (max-width: 767px) {
            .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-profile .nav-link .nav-profile-name {
                display: contents;
            }
        }
    </style>
    @yield('style')
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include("frontend.dashboard.partials.header")
    <div class="container-fluid page-body-wrapper">
        @include("frontend.dashboard.partials.sidebar")
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    @yield("content")
                </div>
            </div>
        </div>
    </div>
    <!-- partial -->
    @if(!\Illuminate\Support\Facades\Request::is("dashboard/profile/edit") && \Illuminate\Support\Facades\Session::has("postData"))
        @php \Illuminate\Support\Facades\Session::forget("postData"); @endphp
    @endif

    @if(!\Illuminate\Support\Facades\Request::is('login') && \Illuminate\Support\Facades\Session::has("agent-rating-flash"))
        @php \Illuminate\Support\Facades\Session::has("agent-rating-flash"); @endphp
    @endif

    @if(!\Illuminate\Support\Facades\Request::is('login') && \Illuminate\Support\Facades\Session::has("agent_rating_data_status"))
        @php \Illuminate\Support\Facades\Session::has("agent_rating_data_status"); @endphp
    @endif
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="{{asset("assets/vendors/base/vendor.bundle.base.js")}}"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="{{asset("assets/vendors/chart.js/Chart.min.js")}}"></script>
<script src="{{asset("assets/vendors/datatables.net/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js")}}"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="{{asset("assets/js/off-canvas.js")}}"></script>
<script src="{{asset("assets/js/hoverable-collapse.js")}}"></script>
<script src="{{asset("assets/js/template.js")}}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{asset("assets/js/dashboard.js")}}"></script>
<script src="{{asset("assets/js/data-table.js")}}"></script>
<script src="{{asset("assets/js/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/js/dataTables.bootstrap4.js")}}"></script>
<!-- End custom js for this page-->
<script src="{{asset("assets/js/jquery.cookie.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/my-js.js")}}" type="text/javascript"></script>

<script src="{{asset("assets/alertify/alertify.min.js")}}"></script>
<script src="{{asset("assets/flatpickr/flatpickr.min.js")}}"></script>
{{--<script src="https://unpkg.com/@popperjs/core@2"></script>--}}
{{--<script src="{{asset("assets/bootstrap/js/bootstrap-select.min.js")}}"></script>--}}


<script>
    var baseUrl = "{{url('/')}}";

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

@yield('script')
</body>

</html>

