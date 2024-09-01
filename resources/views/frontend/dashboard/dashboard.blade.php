@extends("frontend.dashboard.master")

@section('title')
    Dashboard
@stop

@section('content')
    <div class="col-12">
        @include("partials.flash.flash")
    </div>

    @hasanyrole('admin')
    <div class="col-md-3 col-sm-6 dashboard-card mb-3">
        <div class="card">
            <h4 class="card-title">Agents</h4>

            <h5 class="card-description text-center">
                {{$agentCount}}
            </h5>

            <hr>

            <a href="{{url('dashboard/agents')}}">View <i class="mdi mdi-arrow-right-bold"></i></a>
        </div>
    </div>
    @endhasanyrole

    @hasanyrole('admin|agent|tenant')
    <div class="col-md-3 col-sm-6 dashboard-card mb-3">
        <div class="card">
            <h4 class="card-title">Posts</h4>

            <h5 class="card-description text-center">
                {{$postCount}}
            </h5>

            <hr>

            <a href="{{url('dashboard/posts')}}">View <i class="mdi mdi-arrow-right-bold"></i></a>
        </div>
    </div>
    @endhasanyrole
@stop