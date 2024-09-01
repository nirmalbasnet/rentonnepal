@extends("ui.master")

@section('title')
    {{$post->title}}
@stop

@section('body')
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
                <li class="active"><span class="fa fa-angle-right mx-2" aria-hidden="true"></span> {{$post->title}}</li>
            </ul>
        </div>
    </section>

    <section class="w3l-blog post-content py-5">
        <div class="container py-lg-4 py-md-3 py-2">
            <div class="inner mb-4">
                <ul class="blog-single-author-date align-items-center">
                    <li>
                        <div class="listing-category">
                            <span>{{$post->category === "sale" ? 'Buy' : 'Rent'}}</span>
                            <span>{{ucwords($post->sub_category)}}</span>
                            <span class="{{$post->status === "Open" ? "span-info" : "span-danger"}}">{{$post->status === "Open" ? 'Available' : $post->status}}</span>
                        </div>
                    </li>
                    <li><span class="fa fa-clock-o"></span> {{$post->created_at->diffForHumans()}}</li>
                    <li><span class="fa fa-eye"></span> {{$post->view}} views</li>
                </ul>
            </div>
            <div class="post-content mb-1">
                <h2 class="title-single"> {{$post->title}}</h2>
            </div>
            <div class="blo-singl mb-4">
                <ul class="blog-single-author-date align-items-center">
                    <li>
                        <p><i style="color: #FF9933;" class="fa fa-map-marker"></i> {{$post->location}}</p>
                    </li>
                    <li>
                        <p><i style="color: #FF9933;"
                              class="fa fa-phone"></i> {{$post->mobile}} {{$post->additional_mobile ? " / $post->additional_mobile " : ""}}
                        </p>
                    </li>

                    <li style="display: block;" class="mt-1">
                        <p class="cost-estate m-o">
                            @if(isset($post->is_negotiable))
                                Negotiable Price
                            @else
                                Rs. {{$post->price}} @if($post->category === "rent") {{ucwords($post->price_per)}} @endif
                            @endif
                        </p>
                    </li>

                    @if($post->additional_note)
                        <li style="display: block;" class="mt-2">
                            <span><em>* {{$post->additional_note}}</em></span>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-8 w3l-news">
                    <div class="blog-single-post">
                        <div class="single-post-image mb-5">
                            <div class="owl-blog owl-carousel owl-theme">
                                @foreach($post->postImages as $postImage)
                                    <div class="item">
                                        <div class="card">
                                            <img src="{{asset($postImage->image_url)}}" class="img-fluid radius-image"
                                                 alt="{{$post->title}}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="single-post-content">
                            <h3 class="post-content-title mb-3">Description</h3>
                            {!! $post->description !!}
                        </div>

                        {{--<div class="single-bg-white">--}}
                        {{--<h3 class="post-content-title mb-4">Location</h3>--}}
                        {{--<div class="agent-map">--}}
                        {{--<iframe--}}
                        {{--src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387190.2895687731!2d-74.26055986835598!3d40.697668402590374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sin!4v1562582305883!5m2!1sen!2sin"--}}
                        {{--frameborder="0" style="border:0" allowfullscreen=""></iframe>--}}
                        {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="single-bg-white mb-0">--}}
                        {{--<h3 class="post-content-title mb-4">Video</h3>--}}
                        {{--<div class="post-content">--}}
                        {{--<iframe src="https://www.youtube.com/embed/jqP3m3ElcxA" frameborder="0"--}}
                        {{--allowfullscreen=""></iframe>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div class="sidebar-side col-lg-4 col-md-12 col-sm-12 mt-lg-0 mt-5">
                    <aside class="sidebar">

                        <!-- Popular Post Widget-->
                        @if($post->agent->id != 7)
                            @if($post->agent->user_type === "agent")
                                <div class="sidebar-widget popular-posts">
                                    <div class="sidebar-title">
                                        <h4>Contact an Agent</h4>
                                    </div>

                                    <article class="post">
                                        <figure class="post-thumb"><img src="{{asset($post->agent->profile_pic)}}"
                                                                        class="radius-image"
                                                                        alt="{{$post->agent->name}}">
                                        </figure>
                                        <div class="text mb-0">
                                            <a href="{{url("agents/".$post->agent->slug)}}">
                                                {{$post->agent->name}}
                                            </a>
                                            <div class="post-info">{{$post->agent->mobile}}</div>
                                            <div class="post-info">{{$post->agent->email}}</div>
                                        </div>
                                    </article>
                                    <a href="{{url("agents/".$post->agent->slug)}}">
                                        <button type="submit" class="btn btn-primary btn-style w-100">Agent profile
                                        </button>
                                    </a>
                                </div>
                            @else
                                <div class="sidebar-widget popular-posts">
                                    <div class="sidebar-title">
                                        <h4>Posted By</h4>
                                    </div>

                                    <article class="post">
                                        <figure class="post-thumb"><img src="{{asset($post->agent->profile_pic ? $post->agent->profile_pic : 'assets/images/default-pp.png')}}"
                                                                        class="radius-image"
                                                                        alt="{{$post->agent->name}}">
                                        </figure>
                                        <div class="text mb-0">
                                            <a href="javascript:void(0)">
                                                {{$post->agent->name}}
                                            </a>
                                            <div class="post-info">{{isset($post->agent->mobile) ? $post->agent->mobile : "N/A"}}</div>
                                            <div class="post-info">{{$post->agent->email}}</div>
                                        </div>
                                    </article>
                                </div>
                            @endif
                        @endif


                    <!-- Popular Post Widget-->
                        @if(isset($popularPosts) && $popularPosts->count() > 0)
                            <div class="sidebar-widget popular-posts">
                                <div class="sidebar-title">
                                    <h4>Popular Post</h4>
                                </div>

                                @foreach($popularPosts as $popularPost)
                                    <article class="post">
                                        <figure class="post-thumb">
                                            <img src="{{asset($popularPost->postImages->first()->image_url)}}"
                                                 class="radius-image" alt="{{$popularPost->title}}">
                                        </figure>
                                        <div class="text">
                                            <a href="{{url("properties/$popularPost->category/$popularPost->sub_category/$popularPost->slug")}}">{{$popularPost->title}}</a>
                                            <div class="post-info">{{date("M d, Y", strtotime($popularPost->created_at))}}</div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    </aside>
                </div>
            </div>
        </div>
    </section>
@stop