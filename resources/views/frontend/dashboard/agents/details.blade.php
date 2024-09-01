@extends("frontend.dashboard.master")

@section('title')
    Agent Detail
@stop

@section("style")
    <style>
        div.profile_pic {
            width: 150px;
            height: auto;
        }
    </style>
@stop

@section("content")
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="display-flex justify-content-between align-items-center">
                    <h4 class="card-title">Agent Detail</h4>

                    <div class="search-wrapper">
                        <p class="card-description">
                            <a href="{{url("dashboard/agents")}}">
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
                            <span class="{{$detail->status == 'Active' ? 'span-info' : ($detail->status == 'Pending' ? 'span-warning' : 'span-danger')}}"
                                  id="status">{{$detail->status}}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="name mb-4">
                            <label for="name">Name</label>
                            <p id="name">{{$detail->name}}</p>
                        </div>

                        <div class="email mb-4">
                            <label for="email">Email</label>
                            <p id="email">{{$detail->email}}</p>
                        </div>

                        <div class="mobile mb-4">
                            <label for="mobile">Mobile</label>
                            <p id="mobile">{{$detail->mobile}}</p>
                        </div>

                        <div class="address mb-4">
                            <label for="address">Address</label>
                            <p id="address">{{$detail->address}}</p>
                        </div>

                        <div class="profile_pic mb-4">
                            <label style="display: block" for="profile_pic">Profile Pic</label>
                            @if($detail->profile_pic)
                                <img id="profile_pic" class="img-thumbnail img-responsive"
                                     src="{{asset($detail->profile_pic)}}" alt="">
                            @else
                                <p id="profile_pic">N/A</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="ratings mb-4">
                            <label for="ratings">Ratings</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop