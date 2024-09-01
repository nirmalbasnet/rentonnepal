@extends("frontend.dashboard.master")

@section('title')
    Post Detail
@stop

@section("style")
    <style>
        td.title {
            min-width: 150px;
        }

        td.description {
            min-width: 150px;
        }

        td.price {
            min-width: 100px;
        }

        .post-image-div {
            position: relative;
            border: 1px solid #bbb;
        }

        .post-image-div img {
            display: block;
            margin: 0 auto;
        }

        .post-image-div i {
            position: absolute;
            left: 5px;
            top: 5px;
            cursor: pointer;
            background: darkred;
            padding: 5px;
            color: #fff;
        }
    </style>
@stop

@section("content")
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="display-flex justify-content-between align-items-center">
                    <h4 class="card-title">Post Detail</h4>

                    <div class="search-wrapper">
                        <p class="card-description">
                            <a href="{{url("dashboard/posts")}}">
                                <button type="button" class="btn btn-secondary btn-fw">Back To List
                                </button>
                            </a>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="status mb-4">
                            <label class="d-block mb-2" for="status">Status</label>
                            @if($detail->status === "Open")
                                <span class="span-info" id="status">{{$detail->status}}</span>
                            @else
                                <span class="span-danger" id="status">{{$detail->status}}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="title mb-4">
                            <label for="title">Title</label>
                            <p id="title">{{$detail->title}}</p>
                        </div>

                        <div class="category mb-4">
                            <label for="category">Category</label>
                            <p id="category">{{$detail->category}}</p>
                        </div>

                        <div class="sub_category mb-4">
                            <label for="sub_category">Sub Category</label>
                            <p id="sub_category">{{$detail->sub_category}}</p>
                        </div>

                        <div class="published mb-4">
                            <label for="published">Published</label>
                            <p id="published">{{$detail->published}}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="location mb-4">
                            <label for="location">Location</label>
                            <p id="location">{{$detail->location}}</p>
                        </div>

                        <div class="mobile mb-4">
                            <label for="mobile">Contact Mobile</label>
                            <p id="mobile">{{$detail->mobile}}</p>
                        </div>

                        <div class="mobile mb-4">
                            <label for="additional_mobile">Additional Mobile</label>
                            <p id="mobile">{{isset($detail->additional_mobile) ? $detail->additional_mobile : "N/A"}}</p>
                        </div>

                        <div class="price mb-4">
                            <label for="price">Price</label>
                            @if($detail->is_negotiable)
                                <p id="price">Negotiable Price</p>
                            @else
                                <p id="price">
                                    Rs. {{$detail->price}} @if($detail->category === "rent") {{$detail->price_per}} @endif</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="additional_note mb-4">
                            <label for="additional_note">Additional Note</label>
                            <p id="additional_note">{{isset($detail->additional_note) ? $detail->additional_note : "N/A"}}</p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="description mb-4">
                            <label for="description">Description</label>
                            <p id="description">{!! $detail->description !!}</p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="images">
                    <label class="mb-4" for="images" style="display: block;">Image</label>
                    <div class="row mb-3">
                        @foreach($detail->postImages as $image)
                            <div class="col-md-3 mb-3 post-image-div-{{$image->id}}">
                                <div class="post-image-div" style="height: 150px;">
                                    <img class="img-responsive" src="{{asset($image->image_url)}}"
                                         alt="{{$detail->title}}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop