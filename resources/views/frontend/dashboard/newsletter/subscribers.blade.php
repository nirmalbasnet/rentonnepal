@extends("frontend.dashboard.master")

@section('title')
    Newsletter Subscribers
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
                    <h4 class="card-title">Newsletter Subscribers</h4>
                </div>

                @include("partials.flash.flash")
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Email</th>
                            <th>Subscribed At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($subscribers) && $subscribers->count() > 0)
                            @foreach($subscribers as $datum)
                                <tr>
                                    <td class="title">
                                        {{$datum->email}}
                                    </td>
                                    <td class="">
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
@stop