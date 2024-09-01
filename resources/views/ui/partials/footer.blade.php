<!-- footers 20 -->

@php
    $contactDetails = \App\ContactDetail::first();
@endphp

<section class="w3l-footers-20">
    <div class="footers20">
        <div class="container">
            <div class="footers20-content">
                <div class="d-grid grid-col-4 grids-content">
                    <div class="column">
                        <a href="javascript:void(0)" class="link"><span class="fa fa-comments"></span></a>
                        <a href="javascript:void(0)" class="title-small">Follow us</a>
                        <p>and always keep in touch</p>
                        {{--<h4>Schedule a free consultation with our specialist.</h4>--}}
                        {{--<a href="#buytheme" class="btn btn-style btn-primary"> Schedule now--}}
                            {{--<span class="fa fa-long-arrow-right ml-2"></span> </a>--}}
                        <ul class="footers-17_social">
                            <li><a href="{{$contactDetails && $contactDetails->twitter ? $contactDetails->twitter : 'javascript:void(0)'}}" target="{{$contactDetails && $contactDetails->twitter ? '_blank' : ''}}" class="twitter"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="{{$contactDetails && $contactDetails->facebook ? $contactDetails->facebook : 'javascript:void(0)'}}" target="{{$contactDetails && $contactDetails->facebook ? '_blank' : ''}}" class="facebook"><i class="fab fa-facebook"></i></a></li>
                            <li><a href="{{$contactDetails && $contactDetails->linkedin ? $contactDetails->linkedin : 'javascript:void(0)'}}" target="{{$contactDetails && $contactDetails->linkedin ? '_blank' : ''}}" class="linkedin"><i class="fab fa-linkedin"></i></a></li>
                            <li><a href="{{$contactDetails && $contactDetails->instagram ? $contactDetails->instagram : 'javascript:void(0)'}}" target="{{$contactDetails && $contactDetails->instagram ? '_blank' : ''}}" class="instagram"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                    <div class="column">
                        <a href="javascript:void(0)" class="link"><span class="fa fa-phone"></span></a>
                        <a href="javascript:void(0)" class="title-small">help desk</a>
                        <p>Do you have questions or want more infomation? Call Now</p>
                        <a href="tel:+977-{{$contactDetails && $contactDetails->phone ? $contactDetails->phone : ''}}">
                            <p class="contact-phone mt-2"><span class="lnr lnr-phone-handset"></span>
                                {{$contactDetails && $contactDetails->phone ? $contactDetails->phone : ''}}
                            </p>
                        </a>
                    </div>
                    <div class="column mt-lg-0 mt-md-5">
                        <a href="javascript:void(0)" class="link"><span class="fa fa-envelope"></span></a>
                        <a href="javascript:void(0)" class="title-small">Signup for newsletter</a>
                        <p>and get latest news and updates</p>

                        <form action="#" id="newsletter-form" class="subscribe-form mt-4 text-center" method="post">
                            <div class="form-group mb-1">
                                <input type="email" id="newsletter-email" name="subscribe" placeholder="Enter your email" required="">
                                <button id="newsletter-form-submit" class="btn btn-style btn-primary">Subscribe</button>
                            </div>
                            <span style="color: darkred" id="newsletter-form-error"></span>
                        </form>
                    </div>
                </div>
                <div class="d-grid grid-col-3 grids-content1 bottom-border">
                    <div class="columns copyright-grid align-self">
                        <p class="copy-footer-29">© 2020 Rent On Nepal. All rights reserved | Designed by <a
                                    href="https://cubedsteps.com" target="_blank">Cubed Steps</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- move top -->
    <button onclick="topFunction()" id="movetop" title="Go to top">
        &#10548;
    </button>

    <script>
        $(function () {
            $('.navbar-toggler').click(function () {
                $('body').toggleClass('noscroll');
            })
        });
    </script>

    <script>
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function () {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("movetop").style.display = "block";
            } else {
                document.getElementById("movetop").style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
    <!-- /move top -->
</section>