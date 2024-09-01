@extends("ui.master")

@section("title")
    Privacy Policy
@stop

@section("style")
    <style>
        ul li {
            list-style-type: circle;
            color: var(--font-color);
            opacity: .8;
            margin: 5px 0;
        }
    </style>
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
                <li class="active"><span class="fa fa-angle-right mx-2" aria-hidden="true"></span> Privacy Policy</li>
            </ul>
        </div>
    </section>

    <section class="locations-1" id="locations">
        <div class="locations py-5 home" style="">
            <div class="container py-lg-5 py-md-4 py-2">
                <div class="row">
                    <p>
                        We have created this privacy statement in order to demonstrate our firm and continuing
                        commitment to the privacy of personal information provided by those visiting and interacting
                        with this website. We hold the privacy of your personal information in the highest regard.
                    </p>
                </div>
                <div class="row properties mt-3">
                    <p>We recognize the importance of protecting the personal information you provide at Web sites.
                        Email or phone contact information will not be shared to anyone. Our Site may use “cookies” to
                        enhance User experience. </p>
                </div>

                <div class="row mt-3">
                    <p class="d-block">We use your information to :</p>

                    <div class="col-md-12">
                        <ul class="pl-5">
                            <li>Notify you of updates to our sites.</li>
                            <li>Notify you of relevant products and services.</li>
                            <li>Notify you of upcoming events and programs</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop