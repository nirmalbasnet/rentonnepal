@extends("frontend.dashboard.master")

@section('title')
    Posts
@stop

@section("style")
    <style>
        a.change-status {
            white-space: nowrap;
        }

        a.change-status:hover, a.change-status:focus {
            text-decoration: none;
            outline: none;
        }

        .colored-start{
            color: #FF9933 !important;
        }
    </style>
@stop

@section("content")
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="display-flex justify-content-between align-items-center">
                    <h4 class="card-title">Agents</h4>

                    <div class="search-wrapper">
                        <p class="card-description">
                            <a href="{{url("dashboard/agents/create")}}">
                                <button type="button" class="btn btn-secondary btn-fw">Create New Agent
                                </button>
                            </a>
                        </p>
                    </div>
                </div>

                @include("partials.flash.flash")
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Profile Pic</th>
                            <th>Ratings</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($agents) && $agents->count() > 0)
                            @foreach($agents as $datum)
                                <tr>
                                    <td class="title">
                                        {{$datum->name}}
                                    </td>
                                    <td class="">
                                        {{$datum->mobile}}
                                    </td>
                                    <td class="">
                                        {{$datum->address}}
                                    </td>
                                    <td class="">
                                        {{$datum->email}}
                                    </td>
                                    <td class="">
                                        @if($datum->profile_pic)
                                            <img class="img-thumbnail img-responsive"
                                                 src="{{asset($datum->profile_pic)}}" alt="agent profile pic">
                                        @else
                                            <img class="img-thumbnail img-responsive"
                                                 src="{{asset('assets/images/default-pp.png')}}"
                                                 alt="agent profile pic">
                                        @endif
                                    </td>
                                    <td class="" style="width: 125px;">
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < $datum->average_rating)
                                                <i class="fa fa-star colored-start" style="color: #ddd;"></i>
                                            @else
                                                <i class="fa fa-star" style="color: #ddd;"></i>
                                            @endif
                                        @endfor
                                    </td>
                                    <td class="status">
                                        <span class="status-display-{{$datum->id}}">{{$datum->status}}</span>
                                        <hr>
                                        <div class="status-div-{{$datum->id}}" style="display: flex;">
                                            @if($datum->status == "Pending")
                                                <a href="#" data-id="{{$datum->id}}" data-cs="Pending" data-ns="Active"
                                                   class="change-status span-info mr-1">
                                                    Activate
                                                </a>

                                                <a href="#" data-id="{{$datum->id}}" data-cs="Pending" data-ns="Blocked" class="change-status span-danger">
                                                    Block
                                                </a>
                                            @endif

                                            @if($datum->status == "Active")
                                                <a href="#" class="change-status span-danger"
                                                   data-id="{{$datum->id}}" data-cs="Active" data-ns="Blocked">
                                                    Block
                                                </a>
                                            @endif

                                            @if($datum->status == "Blocked")
                                                <a href="#" class="change-status span-info"
                                                   data-id="{{$datum->id}}" data-cs="Blocked" data-ns="Active">
                                                    Activate
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="action">
                                        <div data-toggle="tooltip" title="Edit Agent" class="pt-2 pb-2">
                                            <a href="{{url("dashboard/agents/$datum->id/edit")}}">
                                                <i style="font-size: 20px;" class="mdi mdi-tooltip-edit"></i>
                                                Edit
                                            </a>
                                        </div>

                                        <div data-toggle="tooltip" title="View Agent Detail" class="pt-2 pb-2">
                                            <a href="{{url("dashboard/agents/$datum->id/details")}}">
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

                    @if(isset($agents) && $agents->count() > 0)
                        {{ $agents->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section("script")
    <script>
        $(document).on("click", "a.change-status", function(event){
            event.preventDefault();
            var userId = $(this).data("id");
            var newStatus = $(this).data("ns");
            var newElement = "<span id='processing-" + userId + "' style='white-space: nowrap;'>Processing <i class='fa fa-spin fa-spinner'></i></span>";
            $(this).replaceWith(newElement);

            $.ajax({
                url: baseUrl + "/dashboard/agents/" + userId + "/change-status?new-status=" + newStatus,
                type: "get",
                success: function (data) {
                    if (data === "Active") {
                        $("div.status-div-"+userId).html('<a href="#" class="change-status span-danger" data-id="'+userId+'" data-cs="Active" data-ns="Blocked">Block</a>');
                    }

                    if (data === "Blocked") {
                        $("div.status-div-"+userId).html('<a href="#" class="change-status span-info"  data-id="'+userId+'" data-cs="Blocked" data-ns="Active">Activate</a>');
                    }

                    $("span.status-display-"+userId).text(data);
                }
            });
        });
    </script>
@stop