@extends("ui.master")

@section("title")
    Complete Profile
@stop

@section("style")
    <style>
        .req {
            color: red;
        }

        .profile-img-div {
            width: 180px;
            height: 200px;
            position: relative;
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
            width: 180px;
            bottom: -40px;
        }

        .form-validation-error{
            color: red;
        }
    </style>
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
                <li class="active"><span class="fa fa-angle-right mx-2" aria-hidden="true"></span> Complete Profile</li>
            </ul>
        </div>
    </section>

    <section class="w3l-contact-7 pt-3" id="contact">
        <div class="contacts-9 pt-lg-5 pt-md-4">
            <div class="container">
                <div class="top-map">
                    <div class="row map-content-9">
                        <div class="col-lg-12" style="margin-bottom: 5rem;">
                            <div class="contact-form">
                                <div class="row">
                                    <div class="col-lg-6">
                                        @include("partials.flash.flash")
                                        <h5 class="mb-2">Complete your agent profile</h5>

                                        <form enctype="multipart/form-data" action="{{url("complete-profile/$user->slug/submit")}}" method="post"
                                              class="">
                                            @csrf

                                            <input type="hidden" name="redirectUrl" value="{{$redirectUrl}}">

                                            <div class="form-group">
                                                <div class="input-field">
                                                    <label for="mobile">Mobile <span class="req">*</span></label>
                                                    <input type="text" value="{{old('mobile')}}" name="mobile"
                                                           id="mobile"
                                                           placeholder="eg: 98########, 98########"
                                                           required="">
                                                    @error('mobile')
                                                    <span class="form-validation-error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="input-field">
                                                    <label for="address">Address <span class="req">*</span></label>
                                                    <input type="text" value="{{old('address')}}" name="address"
                                                           id="address"
                                                           placeholder="eg: Sukedhara, Kathmandu"
                                                           required="">
                                                    @error('address')
                                                    <span class="form-validation-error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group mt-3 mb-5">
                                                <div class="profile-img-div">
                                                    <label for="upload-photo">Profile Picture</label>

                                                    <img id="blah" src="{{asset("assets/images/default-pp.png")}}"
                                                         alt="profile pic" class="thumbnail"
                                                         style="height: 100%; width: 100%;">

                                                    <div class="file-picker">
                                                        <label for="upload-photo">Upload
                                                            <i data-toggle="tooltip"
                                                               class="fa fa-info-circle"
                                                               title="Allowed extension is jpg/jpeg/png/bmp">
                                                            </i>
                                                        </label>
                                                        <input accept="image/*" type="file" name="profile_pic"
                                                               id="upload-photo"/>
                                                    </div>
                                                </div>

                                                @error('profile_pic')
                                                <span style="display: block; margin-top: 40px;" class="form-validation-error">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-style mt-3" style="{{isset($errors) && $errors->has("profile_pic") ? 'margin-top: -2rem !important;' : ''}}">Submit
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-lg-6">
                                        <h5 class="mb-5"></h5>
                                        <p style="text-align: justify">
                                            Being an agent, user can see your posts and contact you directly.
                                            All your post will be listed on your profile. You can get rated and reviewed
                                            from users. Your property can be listed on top as per your reviews.
                                        </p>

                                        <p class="mt-3">
                                            Also, your post will reach to thousands of people and help you find
                                            the customer quickly through our social media platforms.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section("script")
    <script>
        function isNumber(evt, element) {

            var charCode = (evt.which) ? evt.which : event.keyCode;

            if(charCode === 44 || charCode === 32)
                return true;

            if (
                (charCode < 48 || charCode > 57) &&
                (charCode != 8) &&
                (charCode != 199))
                return false;

            return true;
        }

        $('input#mobile').keypress(function (event) {
            return isNumber(event, this)
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