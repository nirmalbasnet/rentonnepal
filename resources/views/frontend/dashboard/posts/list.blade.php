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
    </style>
@stop

@section("content")
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="display-flex justify-content-between align-items-center">
                    <h4 class="card-title">Posts</h4>

                    @hasanyrole('agent|admin|tenant')
                    <div class="search-wrapper">
                        <p class="card-description">
                            <a href="{{url("dashboard/posts/create")}}">
                                <button type="button" class="btn btn-secondary btn-fw">Create New Post
                                </button>
                            </a>
                        </p>
                    </div>
                    @endhasanyrole
                </div>

                @include("partials.flash.flash")
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            @hasanyrole('admin')
                            <th>Posted By</th>
                            @endhasanyrole
                            <th>Title</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Location</th>
                            <th>Contact</th>
                            <th>Price</th>
                            {{--<th>Note</th>--}}
                            {{--<th>Description</th>--}}
                            <th>Published</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($posts) && $posts->count() > 0)
                            @foreach($posts as $datum)
                                <tr>
                                    @hasanyrole('admin')
                                    <td>
                                        {{$datum->agent->name}} ({{$datum->agent->user_type === 'agent' ? 'Agent' : 'User'}})
                                    </td>
                                    @endhasanyrole
                                    <td class="title">
                                        {{$datum->title}}
                                    </td>
                                    <td class="">
                                        {{$datum->category}}
                                    </td>
                                    <td class="">
                                        {{$datum->sub_category}}
                                    </td>
                                    <td class="">
                                        {{$datum->location}}
                                    </td>
                                    <td class="">
                                        {{$datum->mobile}}
                                        @if($datum->additional_mobile)
                                            <span style="display: block;">{{$datum->additional_mobile}}</span>
                                        @endif
                                    </td>
                                    <td class="price">
                                        @if(isset($datum->is_negotiable))
                                            Negotiable
                                        @else
                                            Rs. {{$datum->price}} @if($datum->category === "rent") {{$datum->price_per}} @endif
                                        @endif
                                    </td>
                                    {{--<td>{{isset($datum->additional_note) ? $datum->additional_note : "N/A"}}</td>--}}
                                    {{--<td class="description">--}}
                                    {{--{!! \Illuminate\Support\Str::words(strip_tags($datum->description), 10, ' ...') !!}--}}
                                    {{--</td>--}}
                                    <td class="">
                                        <span id="publish-status-{{$datum->id}}">{{$datum->published}}</span>
                                        @hasanyrole('admin')
                                        <hr>
                                        <a href="#" class="change-status"
                                           onclick="changePublishStatus(event, this, '{{$datum->id}}')">
                                            @if($datum->published === "No")
                                                Publish Now
                                            @else
                                                Unpublish Now
                                            @endif
                                        </a>
                                        @endhasanyrole
                                    </td>
                                    <td class="">
                                        <span id="category-status-span-{{$datum->id}}">{{$datum->status}}</span>
                                        @hasanyrole('agent|admin|tenant')
                                        @if($datum->status === "Open")
                                            <div id="category-status-{{$datum->id}}">
                                                <hr>
                                                <a onclick="changeCategoryStatus(event, this, '{{$datum->id}}')"
                                                   href="#" class="change-status">
                                                    @if($datum->category === "rent")
                                                        Mark As Rented
                                                    @else
                                                        Mark As Sold
                                                    @endif
                                                </a>
                                            </div>
                                         @else
                                            <div id="category-status-{{$datum->id}}">
                                                <hr>
                                                <a onclick="changeCategoryStatus(event, this, '{{$datum->id}}')"
                                                   href="#" class="change-status">
                                                    Reopen Post
                                                </a>
                                            </div>
                                        @endif
                                        @endhasanyrole
                                    </td>
                                    <td class="action">
                                        @hasanyrole('agent|tenant')
                                        @if($datum->published == "No" && $datum->status == "Open")
                                            <div data-toggle="tooltip" title="Edit Post" class="pt-2 pb-2">
                                                <a href="{{url("dashboard/posts/$datum->id/edit")}}">
                                                    <i style="font-size: 20px;" class="mdi mdi-tooltip-edit"></i>
                                                    Edit
                                                </a>
                                            </div>
                                        @endif
                                        @endhasanyrole

                                        @hasanyrole('admin')
                                        <div data-toggle="tooltip" title="Edit Post" class="pt-2 pb-2">
                                            <a href="{{url("dashboard/posts/$datum->id/edit")}}">
                                                <i style="font-size: 20px;" class="mdi mdi-tooltip-edit"></i>
                                                Edit
                                            </a>
                                        </div>
                                        @endhasanyrole


                                        <div data-toggle="tooltip" title="View Post Detail" class="pt-2 pb-2">
                                            <a href="{{url("dashboard/posts/$datum->id/details")}}">
                                                <i style="font-size: 20px;" class="mdi mdi-tooltip-edit"></i>
                                                Details
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    @if(isset($posts) && $posts->count() > 0)
                        {{ $posts->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section("script")
    <script>
        function changePublishStatus(event, element, postId) {
            event.preventDefault();
            var publishText = $(element).text().trim();

            var newElement = "<span id='processing-" + postId + "' style='white-space: nowrap;'>Processing <i class='fa fa-spin fa-spinner'></i></span>";

            $(element).replaceWith(newElement);


            $.ajax({
                url: baseUrl + "/dashboard/posts/" + postId + "/change-publish-status",
                type: "get",
                success: function (data) {
                    if (publishText === "Unpublish Now") {
                        $(element).text("Publish Now");
                        $('span#processing-' + postId).replaceWith(element);
                        $('span#publish-status-' + postId).text("No");
                    } else {
                        $(element).text("Unpublish Now");
                        $('span#processing-' + postId).replaceWith(element);
                        $('span#publish-status-' + postId).text("Yes");
                    }
                }
            });
        }

        function changeCategoryStatus(event, element, postId) {
            event.preventDefault();

            var newElement = "<span id='processing-" + postId + "' style='white-space: nowrap;'>Processing <i class='fa fa-spin fa-spinner'></i></span>";

            $(element).replaceWith(newElement);


            $.ajax({
                url: baseUrl + "/dashboard/posts/" + postId + "/change-category-status",
                type: "get",
                success: function (data) {
                    $("#category-status-" + postId).remove();
                    $("#category-status-span-" + postId).text(data);
                }
            });
        }
    </script>
@stop