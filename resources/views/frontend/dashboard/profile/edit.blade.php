@extends("frontend.dashboard.master")

@section('title')
    Update Profile
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

        button.edit {
            font-size: 12px;
            padding: 5px 15px;
        }

        div.file-picker label {
            cursor: pointer;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            text-align: center;
            padding: 15px;
            color: #eee;
            font-weight: 600;
        }

        div.file-picker #upload-photo {
            opacity: 0;
            position: absolute;
            z-index: -1;
        }

        div.file-picker {
            position: absolute;
            width: 150px;
            bottom: 55px;
        }
    </style>
@stop

@section("content")
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                @include("partials.flash.flash")
                <div class="display-flex justify-content-between align-items-center">
                    <h4 class="card-title">Update Profile</h4>

                    <div class="search-wrapper">
                        <p class="card-description">
                            <button form="profile-edit-form" type="submit" class="btn btn-secondary btn-fw">
                                <span class="mdi mdi-tooltip-edit"></span> Update
                            </button>
                        </p>
                    </div>
                </div>


                <form enctype="multipart/form-data" action="{{url("dashboard/profile/update")}}" method="post"
                      id="profile-edit-form">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-2">
                            <div class="name mb-3">
                                <label for="name">Name <span class="req">*</span></label>
                                <input required value="{{old("name", @$profile->name)}}" type="text" name="name"
                                       class="form-control" id="name" placeholder="John Doe">
                                @error('name')
                                <span class="form-validation-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mobile mb-3">
                                <label for="mobile">Mobile <span class="req">*</span></label>
                                <input required value="{{old("mobile", @$profile->mobile)}}" type="text" name="mobile"
                                       class="form-control" id="mobile" placeholder="98########, 98########">
                                @error('mobile')
                                <span class="form-validation-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="address mb-3">
                                <label for="address">Address <span class="req">*</span></label>
                                <input required value="{{old("address", @$profile->address)}}" type="text"
                                       name="address"
                                       class="form-control" id="address" placeholder="Chabahil, Kathmandu">
                                @error('address')
                                <span class="form-validation-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 pp-parent-div">
                            <div class="profile-img-div">
                                <img  id="blah" src="{{asset(isset($profile->profile_pic) ? $profile->profile_pic : "assets/images/default-pp.png")}}"
                                     alt="profile pic" class="thumbnail" style="height: 100%; width: 100%;">

                                <div class="file-picker">
                                    <label for="upload-photo">Upload <i data-toggle="tooltip" class="fa fa-info-circle" title="Allowed extension is jpg/jpeg/png/bmp"></i> @if(!isset($profile->profile_pic))<span class="req">*</span>@endif</label>
                                    <input accept="image/*" type="file" name="profile_pic" id="upload-photo"/>
                                </div>
                                <span class="req img-validation" style="font-size: 10px;">Please upload your profile image</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section("script")
    <script>
        var pp = "{{$profile->profile_pic}}";

        $(function() {
            $("span.img-validation").hide();
        });

        $("#profile-edit-form").on("submit", function(e){
            if(!pp){
                if($("#upload-photo").val() === ""){
                    e.preventDefault();
                    $("span.img-validation").show();
                }
            }
        });

        $("#upload-photo").change(function() {
            $("span.img-validation").hide();
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@stop