@extends("ui.master")

@section("title")
    Properties
@stop

@section("body")
    <section class="w3l-about-breadcrumb">
        <div class="breadcrumb-bg breadcrumb-bg-about pt-5">
            <div class="container pt-lg-5 py-3">
            </div>
        </div>
    </section>

    <section class="w3l-breadcrumb">
        <div class="container">
            <ul class="breadcrumbs-custom-path">
                <li><a href="{{url('/')}}">Home</a></li>
                <li><span class="fa fa-angle-right mx-2" aria-hidden="true"></span><a href="{{url('properties')}}">Properties</a>
                </li>
                <li class="active"><span class="fa fa-angle-right mx-2" aria-hidden="true"></span> Buy</li>
            </ul>
        </div>
    </section>

    <section class="locations-1" id="locations">
        <div class="locations py-5 home">
            <div class="container py-lg-5 py-md-4 py-2">
                <div class="row properties">
                    @if($posts && $posts->count() > 0)
                        @foreach($posts as $post)
                            <div class="col-lg-4 col-md-6 listing-img mb-5">
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
                                        </div>
                                    </div>
                                </a>

                                <div class="listing-details blog-details align-self">
                                    <h4 class="user_title agent">
                                        <a href="{{url("properties/".strtolower($post->category)."/".strtolower($post->sub_category)."/".strtolower($post->slug))}}">{{$post->title}}</a>
                                    </h4>
                                    <p class="user_position">{{$post->location}}</p>
                                    {{--<ul class="mt-3 estate-info">--}}
                                    {{--<li><span class="fa fa-bed"></span> 1 Bed</li>--}}
                                    {{--<li><span class="fa fa-shower"></span> 2 Baths</li>--}}
                                    {{--<li><span class="fa fa-share-square-o"></span> 1760 Sqft</li>--}}
                                    {{--</ul>--}}
                                    <div class="author align-items-center mt-4">
                                        @if($post->agent->id != 7)
                                            @if($post->agent->user_type === "agent")
                                                <a href="{{url("agents/".$post->agent->slug)}}" class="comment-img">
                                                    <img src="{{$post->agent->profile_pic ? asset($post->agent->profile_pic) : asset("assets/images/default-pp.png")}}"
                                                         alt="" class="img-fluid">
                                                </a>
                                                <ul class="blog-meta">
                                                    <li>
                                                        <a href="{{url("agents/".$post->agent->slug)}}">{{$post->agent->name}} </a>
                                                    </li>
                                                    <li class="meta-item blog-lesson">
                                                        <span class="meta-value"> Agent</span>
                                                    </li>
                                                </ul>
                                            @else
                                                <a href="{{url("user/".$post->agent->slug)}}" class="comment-img">
                                                    <img src="{{$post->agent->profile_pic ? asset($post->agent->profile_pic) : asset("assets/images/default-pp.png")}}"
                                                         alt="" class="img-fluid">
                                                </a>
                                                <ul class="blog-meta">
                                                    <li>
                                                        <a href="javascript:void(0)">{{$post->agent->name}} </a>
                                                    </li>
                                                    <li class="meta-item blog-lesson">
                                                        <span class="meta-value"> User</span>
                                                    </li>
                                                </ul>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h2>Currently there is no property available</h2>
                    @endif
                </div>


                <!-- pagination -->
                <div class="pagination-wrapper mt-5 pt-lg-3 text-center">
                    {{$posts->links()}}
                </div>
                <!-- //pagination -->
            </div>
        </div>
    </section>
@stop