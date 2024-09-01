@extends("frontend.dashboard.master")

@section('title')
    Posts
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

        a.change-status {
            white-space: nowrap;
        }

        a.change-status:hover, a.change-status:focus {
            text-decoration: none;
            outline: none;
        }

        .colored-start {
            color: #FF9933 !important;
        }
    </style>
@stop

@section("content")
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="display-flex justify-content-between align-items-center">
                    <h4 class="card-title">Agent Rating</h4>


                    <div class="search-wrapper">
                        <p class="card-description">

                        </p>
                    </div>
                </div>

                @include("partials.flash.flash")
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Agent</th>
                            <th>Rated By</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Rated On</th>
                            <th>Is Published</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($data) && $data->count() > 0)
                            @foreach($data as $datum)
                                <tr>
                                    <td class="title">
                                        <a target="_blank"
                                           href="{{url("dashboard/agents/".$datum->agent->id."/details")}}">{{$datum->agent->name}}</a>
                                    </td>
                                    <td class="">
                                        {{$datum->user->name}}
                                    </td>
                                    <td style="min-width: 125px;">
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < $datum->rate)
                                                <i class="fa fa-star colored-start" style="color: #ddd;"></i>
                                            @else
                                                <i class="fa fa-star" style="color: #ddd;"></i>
                                            @endif
                                        @endfor
                                    </td>
                                    <td class="">
                                        {{$datum->review}}
                                    </td>
                                    <td class="">
                                        {{date("Y-m-d h:i A", strtotime($datum->created_at))}}
                                    </td>
                                    <td>
                                        <span id="publish-status-{{$datum->id}}">{{$datum->publish}}</span>
                                        <hr>
                                        <a href="#" class="change-status"
                                           onclick="changePublishStatus(event, this, '{{$datum->id}}')">
                                            @if($datum->publish === "No")
                                                Publish Now
                                            @else
                                                Unpublish Now
                                            @endif
                                        </a>
                                    </td>
                                    <td class="action">
                                        <div data-toggle="tooltip" title="Delete Data" class="pt-2 pb-2">
                                            <a href="#" class="delete-rating" data-id="{{$datum->id}}">
                                                <i style="font-size: 20px;" class="mdi mdi-delete-forever"></i>
                                                Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    @if(isset($data) && $data->count() > 0)
                        {{ $data->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section("script")
    <script>
        function changePublishStatus(event, element, dataId) {
            event.preventDefault();
            var publishText = $(element).text().trim();

            var newElement = "<span id='processing-" + dataId + "' style='white-space: nowrap;'>Processing <i class='fa fa-spin fa-spinner'></i></span>";

            $(element).replaceWith(newElement);


            $.ajax({
                url: baseUrl + "/dashboard/agent-rating/" + dataId + "/change-publish-status",
                type: "get",
                success: function (data) {
                    if (publishText === "Unpublish Now") {
                        $(element).text("Publish Now");
                        $('span#processing-' + dataId).replaceWith(element);
                        $('span#publish-status-' + dataId).text("No");
                    } else {
                        $(element).text("Unpublish Now");
                        $('span#processing-' + dataId).replaceWith(element);
                        $('span#publish-status-' + dataId).text("Yes");
                    }
                }
            });
        }

        $(document).on('click', '.delete-rating', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            alertify.confirm('Delete Confirmation', 'Are you sure to delete this data?', function () {
                    window.location = baseUrl+"/dashboard/agent-rating/"+id+"/delete";
                }
                , function () {

                });
        });
    </script>
@stop