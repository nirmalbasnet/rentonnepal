@extends("ui.master")

@section("title")
    Home
@stop

@section("style")
    <style>

    </style>
@stop

@section("body")
    <section class="w3l-cover-3">
        <div class="cover top-bottom" style="background: url({{asset('assets/images/banner/landing-page-bg.jpg')}})">
            <div class="container">
                <div class="middle-section text-center">
                    <div class="section-width">
                        <p>It's great to be home.</p>
                        <h2>Find your dream property today!!</h2>
                        <div class="most-searches">
                            {{--<h4>Most Searches</h4>--}}
                            {{--<ul>--}}
                            {{--<li><a href="#link">Kathmandu</a></li>--}}
                            {{--<li><a href="#link">Villa</a></li>--}}
                            {{--<li><a href="#link">Villa</a></li>--}}
                            {{--<li><a href="#link">Apartment</a></li>--}}
                            {{--<li><a href="#link">Private house</a></li>--}}
                            {{--</ul>--}}
                        </div>
                        <form action="{{url("properties/search")}}" class="w3l-cover-3-gd" method="GET">
                            <input style="color: #888 !important;" type="search" name="keyword" placeholder="Enter keywords">

                            <div class="styled-select">
                                <select name="category" required>
                                    <option selected="">Rent</option>
                                    <option>Buy</option>
                                </select>
                            </div>

                            <div class="styled-select">
                                <select name="sub_category" required>
                                    <option>Room</option>
                                    <option>Flat</option>
                                    <option>House</option>
                                    <option>Land</option>
                                </select>
                            </div>

                            <button type="submit" class="btn-primary">Search</button>
                        </form>
                    </div>
                    <section id="bottom" class="demo">
                        <a href="#bottom"><span></span>Scroll</a>
                    </section>
                </div>
            </div>
        </div>
    </section>

    {{--properties--}}
    <section class="locations-1" id="locations">
        <div class="locations py-5 home">
            <div class="container py-lg-5 py-md-4 py-2">
                <div class="heading text-center mx-auto">
                    <h3 class="title-big">Top Properties</h3>
                </div>
                <div class="row pt-md-5 pt-4 properties">
                    @if(isset($posts) && $posts->count() > 0)
                        @foreach($posts as $post)
                            <div class="col-lg-4 col-md-6 mb-5">
                                <a href="{{url("properties/".strtolower($post->category)."/".strtolower($post->sub_category)."/".strtolower($post->slug))}}">
                                    <div class="box16 listing">
                                        <div class="rentext-listing-category">
                                            <span>{{$post->category === "sale" ? 'Buy' : 'Rent'}}</span>
                                            <span>{{ucwords($post->sub_category)}}</span>
                                            <span class="{{$post->status === "Open" ? "span-info" : "span-danger"}}">{{$post->status === "Open" ? 'Available' : $post->status}}</span>
                                        </div>
                                        <img class="img-fluid" src="{{asset($post->postImages->first()->image_url)}}"
                                             alt="">
                                        <div class="box-content">
                                            @if(isset($post->is_negotiable))
                                                <h3 class="title">Negotiable Price</h3>
                                            @else
                                                <h3 class="title">
                                                    Rs. {{$post->price}} @if($post->category === "rent") {{ucwords($post->price_per)}} @endif</h3>
                                            @endif
                                            <span class="post">{{$post->location}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{--about section--}}
    <section class="w3l-index3" id="about">
        <div class="midd-w3 pb-5">
            <div class="container pb-lg-5 pb-md-4 pb-2">
                <div class="row">
                    <div class="col-lg-5 pr-lg-0">
                        <div class="w3l-left-img"
                             style="background: url({{asset('assets/images/about/home-banner.jpg')}}); background-size: cover;">
                        </div>
                    </div>
                    <div class="col-lg-7 pl-lg-0">
                        <div class="w3l-right-info">
                            <h6 class="title-small">Who we are</h6>
                            <h3 class="title-big">We can help you find your dream house.</h3>
                            <p class="mt-4">
                                With excellent real estate agents working in our company, we can assure you
                                that you can find your perfect home in any part of the country.
                            </p>
                            <p class="mt-3">Benefits of working with us:</p>
                            <ul class="w3l-right-book w3l-right-book-grid mt-md-5 mt-4">
                                <li><span class="fa fa-check" aria-hidden="true"></span>Outstanding properties</li>
                                <li><span class="fa fa-check" aria-hidden="true"></span>Reasonable pricings</li>
                                <li><span class="fa fa-check" aria-hidden="true"></span>Get expert advice</li>
                                <li><span class="fa fa-check" aria-hidden="true"></span>Special offers</li>
                                <li><span class="fa fa-check" aria-hidden="true"></span>Experts in the field</li>
                                <li><span class="fa fa-check" aria-hidden="true"></span>Vision & strategy</li>
                            </ul>
                            {{--<a href="{{url('services')}}" class="btn btn-style btn-primary mt-4">Discover our--}}
                            {{--services</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--buy sell section--}}
    <section class="w3l-bottom-grids py-5" id="steps">
        <div class="container py-lg-5 py-md-4 py-2">
            <div class="grids-area-hny main-cont-wthree-fea row justify-content-center">
                <div class="col-lg-4 col-md-6 grids-feature">
                    <div class="area-box no-box-shadow">
                        <span class="fa fa-home"></span>
                        <h4><a href="{{url("properties/buy")}}" class="title-head">Buy a property</a></h4>
                        <p>Any part of country. Find your perfect dream property.</p>
                        <a href="{{url("properties/buy")}}" class="more">Buy now<span
                                    class="fa fa-long-arrow-right"></span> </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 grids-feature mt-md-0 mt-4">
                    <div class="area-box no-box-shadow">
                        <span class="fa fa-home"></span>
                        <h4><a href="{{url("properties/rent")}}" class="title-head">Rent a property </a></h4>
                        <p>Here for a few days? Let's just find a property for you to rent.</p>
                        <a href="{{url("properties/rent")}}" class="more">Rent now<span
                                    class="fa fa-long-arrow-right"></span> </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--agent section--}}
    <section class="w3l-index3" id="agent">
        <div class="midd-w3 py-5">
            <div class="container pb-lg-5 pb-md-4 pb-2">
                <div class="row">
                    <div class="col-lg-5 pr-lg-0">
                        <div class="w3l-left-img1"
                             style="background: url({{asset('assets/images/agent/home-banner.jpg')}}); background-size: cover;">
                        </div>
                    </div>
                    <div class="col-lg-7 pl-lg-0">
                        <div class="w3l-right-info">
                            <h6 class="title-small">Our Agents</h6>
                            <div class="client-grid">
                                <div class="client-title">
                                    <h3 class="title-big">Experts that can guide you.</h3>
                                </div>
                                <div class="clients-info">
                                    {{--<h3 class="title-big">5,200</h3>--}}
                                    {{--<p>Satisfied customers</p>--}}
                                </div>
                            </div>

                            <div class="w3l-clients" id="testimonials">
                                <div id="owl-demo1" class="owl-carousel owl-theme mt-4 pt-2 mb-4">
                                    @if(isset($agents) && $agents->count() > 0)
                                        @foreach($agents as $agent)
                                            <div class="item">
                                                <div class="testimonial-content">
                                                    <div class="testimonial">
                                                        <div class="testi-des">
                                                            <div class="peopl align-self">
                                                                <h4>
                                                                    <a href="{{url("agents/$agent->slug")}}">{{$agent->name}}</a>
                                                                </h4>
                                                                <p class="indentity">Agent from {{$agent->address}}</p>
                                                            </div>
                                                        </div>

                                                        <blockquote>
                                                            @for($i = 0; $i < 5; $i++)
                                                                @if($i < $agent->average_rating)
                                                                    <i class="fas fa-star"></i>
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                @endif
                                                            @endfor
                                                        </blockquote>

                                                        {{--<p>{{$agent->agentRating->count()}} reviews</p>--}}
                                                        {{--</blockquote>--}}
                                                        {{--<blockquote>Over <b>50 real estate</b> deals done.</blockquote>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <a href="{{url('agents')}}" class="btn btn-style btn-primary mt-5">View our agents</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section("script")
    <script>
        var x, i, j, l, ll, selElmnt, a, b, c;
        /*look for any elements with the class "styled-select":*/
        x = document.getElementsByClassName("styled-select");
        l = x.length;
        for (i = 0; i < l; i++) {
            selElmnt = x[i].getElementsByTagName("select")[0];
            ll = selElmnt.length;
            /*for each element, create a new DIV that will act as the selected item:*/
            a = document.createElement("DIV");
            a.setAttribute("class", "select-selected");
            a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
            x[i].appendChild(a);
            /*for each element, create a new DIV that will contain the option list:*/
            b = document.createElement("DIV");
            b.setAttribute("class", "select-items select-hide");
            for (j = 0; j < ll; j++) {
                /*for each option in the original select element,
                create a new DIV that will act as an option item:*/
                c = document.createElement("DIV");
                c.innerHTML = selElmnt.options[j].innerHTML;

                if (j === 0) {
                    c.setAttribute("class", "same-as-selected");
                }

                c.addEventListener("click", function (e) {
                    /*when an item is clicked, update the original select box,
                    and the selected item:*/
                    var y, i, k, s, h, sl, yl;
                    s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                    sl = s.length;
                    h = this.parentNode.previousSibling;
                    for (i = 0; i < sl; i++) {
                        if (s.options[i].innerHTML == this.innerHTML) {
                            s.selectedIndex = i;
                            h.innerHTML = this.innerHTML;
                            y = this.parentNode.getElementsByClassName("same-as-selected");
                            yl = y.length;
                            for (k = 0; k < yl; k++) {
                                y[k].removeAttribute("class");
                            }

                            this.setAttribute("class", "same-as-selected");
                            break;
                        }
                    }
                    h.click();
                });
                b.appendChild(c);
            }
            x[i].appendChild(b);
            a.addEventListener("click", function (e) {
                /*when the select box is clicked, close any other select boxes,
                and open/close the current select box:*/
                e.stopPropagation();
                closeAllSelect(this);
                this.nextSibling.classList.toggle("select-hide");
                this.classList.toggle("select-arrow-active");
            });
        }

        function closeAllSelect(elmnt) {
            /*a function that will close all select boxes in the document,
            except the current select box:*/
            var x, y, i, xl, yl, arrNo = [];
            x = document.getElementsByClassName("select-items");
            y = document.getElementsByClassName("select-selected");
            xl = x.length;
            yl = y.length;
            for (i = 0; i < yl; i++) {
                if (elmnt == y[i]) {
                    arrNo.push(i)
                } else {
                    y[i].classList.remove("select-arrow-active");
                }
            }
            for (i = 0; i < xl; i++) {
                if (arrNo.indexOf(i)) {
                    x[i].classList.add("select-hide");
                }
            }
        }

        /*if the user clicks anywhere outside the select box,
        then close all select boxes:*/
        document.addEventListener("click", closeAllSelect);
    </script>
@stop