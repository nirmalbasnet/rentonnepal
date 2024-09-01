<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
          content="Rentonnepal is a web platform for all kinds of real estate solution within Nepal. Here we provide a platform for all the owners and tenants for sharing their all kinds of properties for renting and sale. We also provide updated news, articles, blogs and information on various topics such as Knowledge, Motivations, Sports, Cooking, and so on."/>
    <meta name="keywords"
          content="real estate, mls, houses for sale, homes for sale, for sale by owner, land for sale, commercial real estate, houses for sale near me, mls listings, condos for sale, houses for sale by owner, Flats, Homes, Houses, Rooms, Shops, Buildings, Apartments, Offices,Rent, Sell, Lease, Blogs, Cooking, Knowledge, Motivation, News, Sports, Technology"/>
    <meta name="author" content="Rent On Nepal Pvt. Ltd."/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config("constants.APP_NAME")}} - @yield('title') - Complete real estate solutions</title>

    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}"/>

    <!-- google fonts -->
    <link href="//fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('ui/assets/css/style-starter.css')}}">
    <link rel="stylesheet" href="{{asset('ui/css/overrides.css')}}">
    <link rel="stylesheet" href="{{asset('ui/css/media-query.css')}}">

    <!-- icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
          integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset("assets/alertify/css/alertify.min.css")}}">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <style>
        div.ajs-header {
            display: none !important;
        }
    </style>
@yield('style')

<!-- jQuery and Bootstrap JS -->
    <script src="{{asset('ui/assets/js/jquery-3.3.1.min.js')}}"></script>
</head>
<body>

<!-- Chat Messenger Integration -->
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v9.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<!-- Your Chat Plugin code -->
<div class="fb-customerchat"
     attribution=setup_tool
     page_id="1165081966856099">
</div>

<!--header-->
@include("ui.partials.header")

<!--body-->
@yield("body")

<!-- footer -->
@include('ui.partials.footer')

@if(!\Illuminate\Support\Facades\Request::is("dashboard/profile/edit") && \Illuminate\Support\Facades\Session::has("postData"))
    @php \Illuminate\Support\Facades\Session::forget("postData"); @endphp
@endif

@if(!\Illuminate\Support\Facades\Request::is('login') && \Illuminate\Support\Facades\Session::has("agent-rating-flash"))
    @php \Illuminate\Support\Facades\Session::has("agent-rating-flash"); @endphp
@endif

@if(!\Illuminate\Support\Facades\Request::is('login') && \Illuminate\Support\Facades\Session::has("agent_rating_data_status"))
    @php \Illuminate\Support\Facades\Session::has("agent_rating_data_status"); @endphp
@endif

<script src="{{asset('ui/assets/js/theme-change.js')}}"></script><!-- theme switch js (light and dark)-->

<!-- stats number counter-->
<script src="{{asset('ui/assets/js/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('ui/assets/js/jquery.countup.js')}}"></script>
<!-- owlcarousel -->
<script src="{{asset('ui/assets/js/owl.carousel.js')}}"></script>

<!-- popper -->
<script src="{{asset('assets/popper.min.js')}}"></script>

<!-- bootstrap -->
<script src="{{asset('ui/assets/js/bootstrap.min.js')}}"></script>

<script src="{{asset('ui/assets/js/jquery.magnific-popup.min.js')}}"></script>

<script src="{{asset("assets/alertify/alertify.min.js")}}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    var baseUrl = "{{url('/')}}";

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<!-- script for tesimonials carousel slider -->
<script>
    $(document).ready(function () {
        $("#owl-demo1").owlCarousel({
            loop: true,
            nav: false,
            margin: 50,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                736: {
                    items: 1,
                    nav: false
                }
            }
        })
    })
</script>
<!-- //script for tesimonials carousel slider -->

<script>
    $(document).ready(function () {
        $('.popup-with-zoom-anim').magnificPopup({
            type: 'inline',

            fixedContentPos: false,
            fixedBgPos: true,

            overflowY: 'auto',

            closeBtnInside: true,
            preloader: false,

            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        });

        $('.popup-with-move-anim').magnificPopup({
            type: 'inline',

            fixedContentPos: false,
            fixedBgPos: true,

            overflowY: 'auto',

            closeBtnInside: true,
            preloader: false,

            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-slide-bottom'
        });
    });
</script>

<!-- disable body scroll which navbar is in active -->
<script>
    $(function () {
        $('.navbar-toggler').click(function () {
            $('body').toggleClass('noscroll');
        })
    });
</script>
<!-- disable body scroll which navbar is in active -->

<!-- MENU-JS -->
<script>
    // $(window).on("scroll", function () {
    //     var scroll = $(window).scrollTop();
    //
    //     if (scroll >= 80) {
    //         $("#site-header").addClass("nav-fixed");
    //     } else {
    //         $("#site-header").removeClass("nav-fixed");
    //     }
    // });

    //Main navigation Active Class Add Remove
    $(".navbar-toggler").on("click", function () {
        $("header").toggleClass("active");
    });
    $(document).on("ready", function () {
        if ($(window).width() > 991) {
            $("header").removeClass("active");
        }
        $(window).on("resize", function () {
            if ($(window).width() > 991) {
                $("header").removeClass("active");
            }
        });
    });
</script>
<!-- //MENU-JS -->

<script>
    $('.counter').countUp();
</script>
<!-- //stats number counter -->

<!-- script for blog post slider -->
<script>
    $(document).ready(function () {
        $('.owl-blog').owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            responsiveClass: true,
            autoplay: false,
            autoplayTimeout: 5000,
            autoplaySpeed: 1000,
            autoplayHoverPause: false,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                480: {
                    items: 1,
                    nav: true
                },
                700: {
                    items: 1,
                    nav: true
                },
                1090: {
                    items: 1,
                    nav: true
                }
            }
        })
    });
</script>

{{--store newsletter email--}}
<script>
    $(document).on("submit", "#newsletter-form", function (e) {
        e.preventDefault();

        var email = $("#newsletter-email").val();

        if (!email)
            $("#newsletter-form-error").text("Please provide your email");
        else {
            $("#newsletter-form-error").text("");
            $("#newsletter-form-submit").attr("disabled", true).text("Subscribing");

            $.ajax({
                url: baseUrl + "/newsletter/subscribe?email=" + email,
                type: 'get',
                success: function (data) {
                    if (data === "success") {
                        $("#newsletter-email").val("");
                        alertify.alert("Thank you for subscribing our newsletter. We will keep you posted.");
                        $("#newsletter-form-submit").attr("disabled", false).text("Subscribe");
                    } else {
                        $("#newsletter-form-submit").attr("disabled", false).text("Subscribe");
                        $("#newsletter-form-error").text(data);
                    }
                }
            });
        }
    });
</script>

@yield("script")

</body>

</html>