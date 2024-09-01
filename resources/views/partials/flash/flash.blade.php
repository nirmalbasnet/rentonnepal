@if(\Illuminate\Support\Facades\Session::has("error"))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-triangle" style="color: darkred;"></i></strong> <small>{{\Illuminate\Support\Facades\Session::get("error")}}</small>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(\Illuminate\Support\Facades\Session::has("success"))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><i class="far fa-check-circle" style="color: #58BAD7;"></i></strong> <small>{{\Illuminate\Support\Facades\Session::get("success")}}</small>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif