<html>
<head>
    <title>Error</title>

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

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
        }

        body {
            font-family: 'Kumbh Sans', sans-serif;
            background-image: linear-gradient(#ce1127, #013893);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .error_section_subtitle{
            color: #fff;
            font-size: 2rem;
            line-height: 40px;
        }

        .error_title{
            font-size: 10rem;
            color: #fff;
            font-weight: 900;
        }
    </style>
</head>

<body>
<section class="error_section">
    <div class="container">
        <p class="error_section_subtitle mb-5">{{$message}}</p>
        <h1 class="error_title">
            {{$code}}
        </h1>
        <a href="{{url("/")}}" class="btn btn-style btn-primary">Back to home</a>
    </div>
</section>

<!-- jQuery and Bootstrap JS -->
<script src="{{asset('ui/assets/js/jquery-3.3.1.min.js')}}"></script>

<script src="{{asset('ui/assets/js/theme-change.js')}}"></script><!-- theme switch js (light and dark)-->

<!-- stats number counter-->
<script src="{{asset('ui/assets/js/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('ui/assets/js/jquery.countup.js')}}"></script>
<!-- owlcarousel -->
<script src="{{asset('ui/assets/js/owl.carousel.js')}}"></script>
<!-- bootstrap -->
<script src="{{asset('ui/assets/js/bootstrap.min.js')}}"></script>

<script src="{{asset('ui/assets/js/jquery.magnific-popup.min.js')}}"></script>

<script src="{{asset("assets/alertify/alertify.min.js")}}"></script>

<script>


    const title = document.querySelector('.error_title')


    //////// Light //////////
    document.onmousemove = function (e) {
        var x = e.pageX - window.innerWidth / 2;
        var y = e.pageY - window.innerHeight / 2;

        title.style.setProperty('--x', x + 'px')
        title.style.setProperty('--y', y + 'px')
    }

    ////////////// Shadow ///////////////////
    title.onmousemove = function (e) {
        var x = e.pageX - window.innerWidth / 2;
        var y = e.pageY - window.innerHeight / 2;

        var rad = Math.atan2(y, x).toFixed(2);
        var length = Math.round(Math.sqrt((Math.pow(x, 2)) + (Math.pow(y, 2))) / 10);

        var x_shadow = Math.round(length * Math.cos(rad));
        var y_shadow = Math.round(length * Math.sin(rad));

        title.style.setProperty('--x-shadow', -x_shadow + 'px')
        title.style.setProperty('--y-shadow', -y_shadow + 'px')

    }
</script>
</body>
</html>

