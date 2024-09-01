@extends("ui.master")

@section("title")
    Agents
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
                <li class="active"><span class="fa fa-angle-right mx-2" aria-hidden="true"></span> Agents</li>
            </ul>
        </div>
    </section>

    <section id="all-agents" class="container">
        <div class="locations home">
            <div class="container py-lg-5 py-md-4 py-2">
                <div class="row all-agents__container">
                    @if($agents && $agents->count() > 0)
                        @foreach($agents as $agent)
                            <div class="col-lg-4 col-md-6 mt-lg-0 pt-lg-0 mt-4 pt-md-2 container__agent-box">
                                <div class="container-fluid">
                                    <div class="row agent-box__image-details align-items-center pad-20">
                                        <div class="col-3 image-details__image">
                                            <div class="image--image"
                                                 style="background-image: url({{asset($agent['profile_pic'] ? $agent['profile_pic'] : "assets/images/default-pp.png")}}); background-size: cover;"></div>
                                        </div>
                                        <div class="col-9 image-details__details">
                                            <div class="details--name agent-box__view-all">
                                                <a href="{{url("agents/".$agent['slug'])}}"><p
                                                            class="view-all">{{$agent['name']}}</p></a>
                                            </div>
                                            {{--<div class="details--rating">--}}
                                            {{--<i class="fas fa-star"></i>--}}
                                            {{--<i class="fas fa-star"></i>--}}
                                            {{--<i class="far fa-star"></i>--}}
                                            {{--<i class="far fa-star"></i>--}}
                                            {{--<i class="far fa-star"></i>--}}

                                            {{--</div>--}}
                                        </div>
                                    </div>
                                    <div class="row agent-box__description pad-20">
                                        <div class="col-12">
                                            <div class="description">
                                                <p><i style="color: #f93" class="fa fa-mobile"></i> {{$agent['mobile']}}
                                                </p>
                                                <p><i style="color: #f93"
                                                      class="fa fa-map-marker"></i> {{$agent['address']}}</p>
                                            </div>
                                        </div>
                                    </div>

                                    @if($agent["total_properties"] > 0)
                                        <div class="row agent-box__view-all pad-20">
                                            <div class="col-12">
                                                <a href="{{url("agents/".$agent['slug']."/properties")}}"><p class="view-all">View all {{$agent["total_properties"]}} properties...</p></a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row agent-box__view-all pad-20" style="padding: 29px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h2>Currently there is no agent available</h2>
                    @endif
                </div>
                <!-- pagination -->
                <div class="pagination-wrapper mt-5 pt-lg-3 text-center">
                    {{--{{$agents->links()}}--}}
                    {{$agents->links()}}
                </div>
                <!-- //pagination -->
            </div>
        </div>
    </section>
@stop