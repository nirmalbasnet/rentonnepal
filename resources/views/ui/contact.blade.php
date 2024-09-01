@extends("ui.master")

@section('title')
    Contact Form
@stop

@section('style')
    <style>
        .form-validation-error {
            color: darkred;
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
                <li class="active"><span class="fa fa-angle-right mx-2" aria-hidden="true"></span> Contact</li>
            </ul>
        </div>
    </section>

    <section class="w3l-contact-7 pt-5" id="contact">
        <div class="contacts-9 pt-lg-5 pt-md-4">
            <div class="container">
                <div class="top-map">
                    <div class="row map-content-9">
                        <div class="col-lg-7">
                            <div class="contact-form">
                                @include("partials.flash.flash")
                                <h5 class="mb-2">Get in touch</h5>
                                <p class="mb-4">Your email address will not be published. Required fields are marked
                                    *</p>
                                <form action="{{url("contact/submit")}}" method="post" class="">
                                    @csrf
                                    <div class="form-grid">
                                        <div class="input-field">
                                            <input type="text" value="{{old('name')}}" name="name" id="name"
                                                   placeholder="Your Name *"
                                                   required="">
                                            @error('name')
                                            <span class="form-validation-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="input-field">
                                            <input type="email" value="{{old('email')}}" name="email" id="email"
                                                   placeholder="Email *"
                                                   required="">
                                            @error('email')
                                            <span class="form-validation-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-field mt-4">
                                        <textarea name="message" id="message" required
                                                  placeholder="Message (max 1000 characters) *">{{old('message')}}</textarea>
                                        @error('message')
                                        <span class="form-validation-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{--<input type="checkbox"> <label>Save my name, email, and website in this--}}
                                    {{--browser for the next time I comment</label>--}}
                                    <button type="submit" class="btn btn-primary btn-style mt-3">Submit</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-5 cont-details">
                            <address>
                                <h5 class="">Our Office Address</h5>
                                <p>
                                    <span class="fa fa-map-marker"></span>
                                    {{isset($contactDetail) && isset($contactDetail->address) ? $contactDetail->address : "N/A"}}
                                </p>

                                <h5 class="mt-4 pt-lg-3">Contact information</h5>


                                <p>
                                    <span class="fa fa-mobile"></span>
                                    <strong>Phone :</strong>
                                    <a href="tel:{{isset($contactDetail) && isset($contactDetail->phone) ? $contactDetail->phone : ''}}"> {{isset($contactDetail) && isset($contactDetail->phone) ? $contactDetail->phone : 'N/A'}}</a>
                                </p>

                                @if(isset($contactDetail) && isset($contactDetail->landline))
                                    <p><span class="fa fa-phone"></span> <strong>Tel :</strong>
                                        <a href="tel:{{isset($contactDetail) && isset($contactDetail->landline) ? $contactDetail->landline : ""}}"> {{isset($contactDetail) && isset($contactDetail->landline) ? $contactDetail->landline : "N/A"}}</a>
                                    </p>
                                @endif

                                <p><span class="fa fa-envelope"></span> <strong>Email :</strong>
                                    <a href="mailto:{{isset($contactDetail) && isset($contactDetail->email) ? $contactDetail->email : ""}}"> {{isset($contactDetail) && isset($contactDetail->email) ? $contactDetail->email : "N/A"}}</a>
                                </p>
                            </address>
                        </div>
                    </div>
                </div>
            </div>

            <div class="map mt-5">
                @if(isset($contactDetail) && isset($contactDetail->google_map_iframe))
                    {!! $contactDetail->google_map_iframe !!}
                @endif
            </div>
        </div>
    </section>
@stop