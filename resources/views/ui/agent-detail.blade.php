@extends("ui.master")

@section('title')
    Agent - {{$agent->name}}
@stop

@section('style')
    <style>
        .agent-detail-rating-block {
            display: flex;
            justify-content: center;
            flex-direction: column;
        }

        .md-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 50%;
            max-width: 630px;
            min-width: 450px;
            height: auto;
            z-index: 2000;
            visibility: hidden;
            -webkit-backface-visibility: hidden;
            -moz-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-transform: translateX(-50%) translateY(-50%);
            -moz-transform: translateX(-50%) translateY(-50%);
            -ms-transform: translateX(-50%) translateY(-50%);
            transform: translateX(-50%) translateY(-50%);
        }

        .md-effect-10.md-modal {
            -webkit-perspective: 1300px;
            -moz-perspective: 1300px;
            perspective: 1300px;
        }

        .md-show {
            visibility: visible;
            box-shadow: 0 0 0 100vmax rgba(0, 0, 0, 0.7);
        }

        .md-show.md-effect-10 .md-content {
            -webkit-transform: rotateX(0deg);
            -moz-transform: rotateX(0deg);
            -ms-transform: rotateX(0deg);
            transform: rotateX(0deg);
            opacity: 1;
        }

        .md-effect-10 .md-content {
            -webkit-transform-style: preserve-3d;
            -moz-transform-style: preserve-3d;
            transform-style: preserve-3d;
            -webkit-transform: rotateX(-60deg);
            -moz-transform: rotateX(-60deg);
            -ms-transform: rotateX(-60deg);
            transform: rotateX(-60deg);
            -webkit-transform-origin: 50% 0;
            -moz-transform-origin: 50% 0;
            transform-origin: 50% 0;
            opacity: 0;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            transition: all 0.3s;
        }

        .md-content {
            color: #fff;
            background: turquoise;
            position: relative;
            border-radius: 3px;
            margin: 0 auto;
        }

        .md-content h3 {
            margin: 0;
            padding: 0.4em;
            text-align: center;
            font-size: 1.8em;
            font-weight: 300;
            opacity: 0.8;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px 3px 0 0;
        }

        .md-content p.validation-error {
            text-align: center;
            font-size: 12px;
            color: red;
            font-weight: 500;
            display: none;
        }

        .md-content label {
            color: #000;
            font-weight: 500;
        }

        .md-content > div {
            padding: 15px 40px 30px;
            margin: 0;
            font-weight: 300;
            font-size: 1.15em;
        }

        .md-content > div p {
            margin: 0;
            padding: 10px 0;
            font-size: 40px;
            text-align: center;
        }

        .md-content > div p i {
            cursor: pointer;
        }

        .md-content button {
            display: block;
            margin: 0 auto;
            font-size: 0.8em;
        }

        button.modal-close {
            border: none;
            padding: 0.6em 1.2em;
            background: #c0392b;
            color: #fff;
            font-family: 'Lato', Calibri, Arial, sans-serif;
            font-size: 1em;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            display: inline-block;
            margin: 3px 2px;
            border-radius: 2px;
        }

        button.modal-submit {
            border: none;
            padding: 0.6em 1.2em;
            background: #f93;
            color: #fff;
            font-family: 'Lato', Calibri, Arial, sans-serif;
            font-size: 1em;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            display: inline-block;
            margin: 3px 2px;
            border-radius: 2px;
            -webkit-transition: transform 10s, border-radius .1s ease-in-out;
            -moz-transition: transform 10s, border-radius .1s ease-in-out;
            -o-transition: transform 10s, border-radius .1s ease-in-out;
            transition: transform 10s, border-radius .1s ease-in-out;
        }

        textarea {
            height: 150px !important;
        }

        @-webkit-keyframes loader-spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @-moz-keyframes loader-spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @-o-keyframes loader-spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes loader-spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .profile-img {
            height: 40px;
            width: 40px;
        }

        .ru-name {
            color: cadetblue;
        }

        p.validation-review-error {
            padding: 0 !important;
        }

        p.char-count {
            color: #fff;
            text-align: right !important;
            font-size: 20px !important;
        }

        .load-more-spinner{
            display: none;
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
                <li><a href="{{url("/")}}">Home</a></li>
                <li><span class="fa fa-angle-right mx-2" aria-hidden="true"></span> <a
                            href="{{url("agents")}}">Agents</a></li>
                <li class="active"><span class="fa fa-angle-right mx-2" aria-hidden="true"></span> {{$agent->name}}</li>
            </ul>
        </div>
    </section>

    <section id="agent-profile" class="container-fluid">
        <div class="row justify-content-center mb-7">
            <div class="col-md-9 col-12 agent-profile__box">
                <div class="container-fluid">
                    <div class="row box__first">
                        <div class="col-12 d-flex justify-content-center">
                            <div class="agent-image"
                                 style="background: url('{{$agent->profile_pic ? asset($agent->profile_pic) : asset("assets/images/default-pp.png")}}'); background-size: cover;"></div>
                        </div>
                    </div>
                    <div class="row box__second">
                        <div class="col-12 d-flex justify-content-center">
                            <h5><b>{{$agent->name}}</b></h5>
                        </div>
                    </div>
                    <div class="row box__third justify-content-center">
                        <div class="col-6 rating-box">
                            <div class="stars">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < $agent->average_rating)
                                        <i style="font-size: 20px;" class="fas fa-star"></i>
                                    @else
                                        <i style="font-size: 20px;" class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="row box__fourth">
                        <div class="col-lg-6 mb-3">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <p>Contact</p>
                                    <h6><b>{{$agent->mobile}}</b></h6>
                                </div>

                                <div class="col-12 mb-3">
                                    <p>Email</p>
                                    <h6><b>{{$agent->email}}</b></h6>
                                </div>

                                <div class="col-12 mb-3">
                                    <p>Address</p>
                                    <h6><b>{{$agent->address}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 agent-detail-rating-block">
                            <div class="row">
                                <div class="col-12">
                                    <div class="">
                                        @if(\Illuminate\Support\Facades\Auth::guest())
                                            <button onclick="showModal()" class="rate-agent">
                                                Rate {{$agent->name}}</button>
                                        @elseif(\Illuminate\Support\Facades\Auth::id() !== $agent->id)
                                            @if($userAgentRate)
                                                <button onclick="showModal()" class="rate-agent">
                                                    View What You Have Reviewed For {{$agent->name}}</button>
                                            @else
                                                <button onclick="showModal()" class="rate-agent">
                                                    Rate {{$agent->name}}</button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($ratings) && $ratings->count() > 0)
                        <hr class="mb-4">
                        @foreach($ratings as $rating)
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="profile-img">
                                        <img class="img-fluid"
                                             src="{{asset($rating->profile_pic ? $rating->profile_pic : 'assets/images/default-pp.png')}}"
                                             alt="">
                                    </div>

                                    <div>
                                        <span class="d-block ru-name mt-3">{{$rating->user->name}}</span>
                                        <span class="d-block">{{\Carbon\Carbon::createFromTimeStamp(strtotime($rating->created_at))->diffForHumans()}}</span>
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <blockquote>
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < $rating->rate)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </blockquote>

                                    <blockquote>
                                        {{$rating->review}}
                                    </blockquote>
                                </div>
                            </div>
                        @endforeach

                        <div id="load-more-rating">
                            <div class="load-more-button-div">
                                @if($ratings->hasMorePages())
                                    <button class="load-more-button">Load More <i class="fa fa-spin fa-spinner load-more-spinner"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Agent Rating Modal -->
        <div class="md-modal md-effect-10" id="modal-1">
            <div class="md-content">
                <h3>Rate {{$agent->name}}</h3>
                <div>
                    <p>
                        @if($userAgentRate)
                            @for($i = 0; $i < 5; $i++)
                                @if($i < $userAgentRate->rate)
                                    <i data-starcount="{{$i}}" class="fas fa-star rating-star rating-star-{{$i}}"></i>
                                @else
                                    <i data-starcount="{{$i}}" class="far fa-star rating-star rating-star-{{$i}}"></i>
                                @endif
                            @endfor
                        @else
                            @for($i = 0; $i < 5; $i++)
                                <i data-starcount="{{$i}}" class="far fa-star rating-star rating-star-{{$i}}"></i>
                            @endfor
                        @endif
                    </p>

                    <p class="validation-error validation-star-error">Please provide your rating</p>

                    <form action="{{url("agents/$agent->slug/submit-review")}}" method="post" id="agent-review-form">
                        @csrf
                        <input type="hidden" name="star_count" id="star_count">
                        <div class="form-group">
                            <label for="review" style="color: #fff;">Review</label>
                            <textarea onkeyup="countChar(event, this)" name="review" class="form-control" id="review"
                                      cols="30"
                                      rows="10">{{@$userAgentRate->review}}</textarea>
                            <div class="text-right text-area-utility">
                                <p class="validation-error validation-review-error">Please provide your review</p>
                                <p class="char-count">
                                    <span id="charNum">0</span>/200
                                </p>
                            </div>
                        </div>
                    </form>

                    <div class="button-section">
                        @if($userAgentRate)
                            <button form="agent-review-form" class="md-submit modal-submit">
                                Update Review
                            </button>
                        @else
                            <button form="agent-review-form" class="md-submit modal-submit">
                                Submit Review
                            </button>
                        @endif

                        <button class="md-close modal-close" onclick="closeModal()">No Thanks!</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script>
        toastr.options.positionClass = "toast-bottom-right";

        @if(\Illuminate\Support\Facades\Session::has("review_success"))
        toastr.success("{{\Illuminate\Support\Facades\Session::get("review_success")}}");
        @endif

        @if(\Illuminate\Support\Facades\Session::has("review_error"))
        toastr.error("{{\Illuminate\Support\Facades\Session::get("review_error")}}");
        @endif

        @if(\Illuminate\Support\Facades\Session::has("with_review_info"))
        toastr.info("{{\Illuminate\Support\Facades\Session::get("with_review_info")}}");
        @endif

        @if(isset($_GET['agent-rating']))
        toastr.info("You have successfully logged in. Now you can rate the agent.");
                @endif

        var starClicked = false;
        var starCount = -1;

        @if($userAgentRate)
            starClicked = true;
        starCount = {{$userAgentRate->rate}} -1;

        @endif

        function showModal() {
            @if(\Illuminate\Support\Facades\Auth::guest())
                    {{\Illuminate\Support\Facades\Session::flash("agent_rating_data_status", "You must first login to submit your review.")}}
                window.location = "{{url('login?agent-rating')}}";
            @else
            $(".md-modal").addClass("md-show");
            @endif
        }

        function closeModal() {
            $(".md-modal").removeClass("md-show");
        }

        $(".rating-star").on("click", function () {
            starClicked = true;
            starCount = $(this).data("starcount");
            $("p.validation-error").hide();
        }).on("mouseover", function () {
            var current = $(this).data("starcount");

            for (var j = 0; j <= current; j++) {
                $(".rating-star-" + j).removeClass("far fa-star").addClass("fas fa-star");
            }

            for (var k = (current + 1); k <= 4; k++) {
                $(".rating-star-" + k).removeClass("fas fa-star").addClass("far fa-star");
            }
        }).on("mouseout", function () {
            if (!starClicked) {
                for (var i = 0; i <= 4; i++) {
                    $(".rating-star-" + i).removeClass("fas fa-star").addClass("far fa-star");
                }
            } else {
                for (var j = 0; j <= starCount; j++) {
                    $(".rating-star-" + j).removeClass("far fa-star").addClass("fas fa-star");
                }

                for (var k = (starCount + 1); k <= 4; k++) {
                    $(".rating-star-" + k).removeClass("fas fa-star").addClass("far fa-star");
                }
            }
        });

        $("#review").on("focus", function () {
            $("p.validation-review-error").hide();
        });

        $("#agent-review-form").on("submit", function (e) {
            if (starCount < 0 || $("#review").val() === "") {
                e.preventDefault();
                if (starCount < 0)
                    $("p.validation-star-error").show();

                if ($("#review").val() === "")
                    $("p.validation-review-error").show();
            } else {
                $("#star_count").val(starCount);
            }
        });

        $(function () {
            if ($("#review").val() !== "") {
                var len = $("#review").val().length;
                $('#charNum').text(len);
            }
        });

        function countChar(event, val) {
            var len = val.value.length;
            if (len > 200) {
                val.value = val.value.substring(0, 200);
            } else {
                $('#charNum').text(len);
            }
        }

        var pageNum = 1;
        $(document).on("click", ".load-more-button", function () {
            $(this).attr("disabled", true);
            $(".load-more-spinner").show();
            var element = $(this);
            pageNum++;
            $.ajax({
                url: baseUrl + "/agents/{{$agent->id}}/load-more-rating?page=" + pageNum,
                type: 'get',
                success: function (data) {
                    $(".load-more-button-div").html("");
                    $("#load-more-rating").append(data);
                    element.attr("disabled", true);
                    $(".load-more-spinner").hide();
                }
            });
        });
    </script>
@stop