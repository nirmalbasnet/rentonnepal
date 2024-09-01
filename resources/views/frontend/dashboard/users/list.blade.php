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
                    <h4 class="card-title">Users</h4>

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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($users) && $users->count() > 0)
                            @foreach($users as $datum)
                                <tr>
                                    <td class="title">
                                        {{$datum->name}}
                                    </td>
                                    <td class="">
                                        {{$datum->email}}
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
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    @if(isset($users) && $users->count() > 0)
                        {{ $users->links() }}
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
                url: baseUrl + "/dashboard/users/" + userId + "/change-status?new-status=" + newStatus,
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