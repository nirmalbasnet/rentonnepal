@extends("frontend.dashboard.master")

@section('title')
    Contact Details
@stop

@section("style")
    <style>

    </style>
@stop

@section("content")
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="display-flex justify-content-between align-items-center">
                    <h4 class="card-title">Contact Details</h4>
                </div>

                <div class="col-md-8">
                    <form class="forms-sample" method="post" enctype="multipart/form-data"
                          action="{{url("dashboard/contacts/store")}}">
                        @csrf

                        @include("partials.flash.flash")

                        <div class="form-group">
                            <label for="email">Email <span class="req">*</span></label>
                            <input required value="{{old("email", @$detail->email)}}" type="email" name="email"
                                   class="form-control" id="email" placeholder="example@example.com">
                            @error('email')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone <span class="req">*</span></label>
                            <input required value="{{old("phone", @$detail->phone)}}" type="text"
                                   name="phone"
                                   class="form-control" id="phone" placeholder="(+977) ########">
                            @error('phone')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="landline">Additional Phone</label>
                            <input value="{{old("landline", @$detail->landline)}}" type="text"
                                   name="landline"
                                   class="form-control" id="landline" placeholder="(+01) ######">
                            @error('landline')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Address <span class="req">*</span></label>
                            <input required value="{{old("address", @$detail->address)}}" type="text"
                                   name="address"
                                   class="form-control" id="address" placeholder="office address">
                            @error('address')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="facebook">Facebook <span class="req">*</span></label>
                            <input required value="{{old("facebook", @$detail->facebook)}}" type="text"
                                   name="facebook"
                                   class="form-control" id="facebook" placeholder="https://www.facebook.com">
                            @error('facebook')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="twitter">Twitter</label>
                            <input value="{{old("twitter", @$detail->twitter)}}" type="text"
                                   name="twitter"
                                   class="form-control" id="twitter" placeholder="https://www.twitter.com">
                            @error('twitter')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="linkedin">Linkedin</label>
                            <input value="{{old("linkedin", @$detail->linkedin)}}" type="text"
                                   name="linkedin"
                                   class="form-control" id="linkedin" placeholder="https://www.linkedin.com">
                            @error('linkedin')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="instagram">Instagram</label>
                            <input value="{{old("instagram", @$detail->instagram)}}" type="text"
                                   name="instagram"
                                   class="form-control" id="instagram" placeholder="https://www.instagram.com">
                            @error('instagram')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="google_map_iframe">Google Map Iframe <span class="req">*</span></label>
                            <textarea required class="form-control" name="google_map_iframe" id="google_map_iframe" cols="30" rows="10">{{old('google_map_iframe', @$detail->google_map_iframe)}}</textarea>
                            @error('google_map_iframe')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                                class="btn btn-secondary btn-fw mr-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section("script")
@stop