@extends("frontend.dashboard.master")

@section('title')
    Messages
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
                    <h4 class="card-title">Contact Messages</h4>
                </div>

                @include("partials.flash.flash")
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Sent On</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($messages) && $messages->count() > 0)
                            @foreach($messages as $datum)
                                <tr>
                                    <td class="title">
                                        {{$datum->name}}
                                    </td>
                                    <td class="title">
                                        {{$datum->email}}
                                    </td>
                                    <td class="title">
                                        <p style="text-align: justify;">{{$datum->message}}</p>
                                        @if($datum->is_responded === "no")
                                            <a href="#" class="change-status"
                                               onclick="changeRespondStatus(event, this, '{{$datum->id}}')">Mark as
                                                Responded</a>
                                        @else
                                            <a href="javascript:void(0)">Responded</a>
                                        @endif
                                    </td>
                                    <td class="" style="width: 180px;">
                                        {{date("M d Y h:i A", strtotime($datum->created_at))}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    @if(isset($subscribers) && $subscribers->count() > 0)
                        {{ $subscribers->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section("script")
    <script>
        function changeRespondStatus(event, element, id) {
            event.preventDefault();
            var newElement = '<a href="javascript:void(0)">Responded</a>';
            var processingElement = '<a id="processing-'+id+'" href="javascript:void(0)">Processing <i class="fa fa-spin fa-spinner"></i></a>'
            $(element).replaceWith(processingElement);

            $.ajax({
               url: baseUrl+"/dashboard/messages/"+id+"/respond",
                type:"get",
                success: function(){
                    $("#processing-"+id).replaceWith(newElement);
                }
            });
        }
    </script>
@stop