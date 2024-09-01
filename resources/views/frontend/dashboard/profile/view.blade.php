@extends("frontend.dashboard.master")

@section('title')
    Profile
@stop

@section("style")
    <style>
        .pp-parent-div {
            align-items: center;
            align-content: center;
            justify-content: left;
            display: flex;
        }

        .profile-img-div {
            width: 150px;
            height: 150px;
        }

        button.edit{
            font-size: 12px;
            padding: 5px 15px;
        }
    </style>
@stop

@section("content")
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="display-flex justify-content-between align-items-center">
                    <h4 class="card-title">Profile Details</h4>

                    <div class="search-wrapper">
                        <p class="card-description">
                            <a href="{{url("dashboard/profile/edit")}}">
                                <button type="button" class="btn btn-secondary btn-fw"><span class="mdi mdi-tooltip-edit"></span> Edit
                                </button>
                            </a>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6  mb-2">
                        <div class="name mb-3">
                            <label for="name">Name</label>
                            <p id="name">{{$profile->name ? $profile->name : "N/A"}}</p>
                        </div>

                        <div class="email mb-3">
                            <label for="email">Email</label>
                            <p id="email">{{$profile->email ? $profile->email : "N/A"}}</p>
                        </div>

                        <div class="mobile mb-3">
                            <label for="mobile">Mobile</label>
                            <p id="mobile">{{$profile->mobile ? $profile->mobile : "N/A"}}</p>
                        </div>

                        <div class="address mb-3">
                            <label for="address">Address</label>
                            <p id="address">{{$profile->address ? $profile->address : "N/A"}}</p>
                        </div>
                    </div>
                    <div class="col-md-6 pp-parent-div">
                        <div class="profile-img-div">
                            <img src="{{asset(isset($profile->profile_pic) ? $profile->profile_pic : "assets/images/default-pp.png")}}"
                                 alt="profile pic" class="thumbnail" style="height: 100%; width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop