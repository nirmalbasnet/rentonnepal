@extends("frontend.dashboard.master")

@section('title')
    {{isset($dataToUpdate) ? "Update" : "Create"}} Post
@stop

@section("style")
    <style>
        div.profile_pic{
            width: 150px;
            height: auto;
        }
    </style>
@stop

@section("content")
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="display-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{isset($dataToUpdate) ? "Update" : "Create"}} Agent</h4>
                    <p class="card-description">
                        <a href="{{url("dashboard/agents")}}">
                            <button type="button" class="btn btn-secondary btn-fw">Back To List</button>
                        </a>
                    </p>
                </div>

                <div class="col-md-8">
                    <form class="forms-sample" method="post" enctype="multipart/form-data"
                          action="{{isset($dataToUpdate) ? url("dashboard/agents/$dataToUpdate->id/update") : url("dashboard/agents/store")}}">
                        @csrf

                        @if(isset($dataToUpdate))
                            @method('patch')
                        @endif

                        @include("partials.flash.flash")

                        <div class="form-group">
                            <label for="name">Name <span class="req">*</span></label>
                            <input required value="{{old("name", @$dataToUpdate->name)}}" type="text" name="name"
                                   class="form-control" id="name" placeholder="John Doe">
                            @error('name')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="req">*</span></label>
                            <input required value="{{old("email", @$dataToUpdate->email)}}" type="email" name="email"
                                   class="form-control" id="email" placeholder="example@example.com">
                            @error('email')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mobile">Mobile <span class="req">*</span></label>
                            <input required value="{{old("mobile", @$dataToUpdate->mobile)}}" type="text" name="mobile"
                                   class="form-control" id="mobile" placeholder="98########, 98########">
                            @error('mobile')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Address <span class="req">*</span></label>
                            <input required value="{{old("address", @$dataToUpdate->address)}}" type="text" name="address"
                                   class="form-control" id="address" placeholder="Chabahil, Kathmandu">
                            @error('address')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password
                                <i data-toggle="tooltip" class="fa fa-info-circle" title="Password should be at least 6 characters long"></i>
                                @if(!isset($dataToUpdate))<span class="req">*</span>@endif
                            </label>
                            <input {{isset($dataToUpdate) ? "" : "required"}} value="" type="password" name="password"
                                   class="form-control" id="password" placeholder="******">
                            @error('password')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="profile_pic">Profile Pic
                                <i data-toggle="tooltip" class="fa fa-info-circle" title="Allowed extension is jpg/jpeg/png/bmp"></i>
                                @if(!isset($dataToUpdate))<span class="req">*</span>@endif
                            </label>

                            @if(isset($dataToUpdate) && $dataToUpdate->profile_pic)
                                <div class="row mb-3">
                                    <div class="col-md-3 mb-3 post-image-div-{{$dataToUpdate->id}}">
                                        <div class="post-image-div profile_pic" style="">
                                            <img class="img-responsive img-thumbnail" src="{{asset($dataToUpdate->profile_pic)}}"
                                                 alt="{{$dataToUpdate->name}}">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <input {{isset($dataToUpdate) ? "" : "required"}} accept="image/*" type="file" id="profile_pic"
                                   name="profile_pic" class="form-control-file">
                            @error('profile_pic')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                                class="btn btn-secondary btn-fw mr-2">{{isset($dataToUpdate) ? "Update" : "Create"}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section("script")
    <script src="{{asset("assets/ckeditor/ckeditor.js")}}"></script>

    <script>
        ClassicEditor.create(document.querySelector('#description'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
            heading: {
                options: [
                    {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
                    {model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1'},
                    {model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2'},
                    {model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3'},
                    {model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4'},
                    {model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5'}
                ]
            }
        });

        function deletePostImage(postImageId){
            $("span.deleting-"+postImageId).css("display", "block");

            $.ajax({
                url: baseUrl+"/dashboard/post-image/"+postImageId+"/delete",
                type: "get",
                success: function (data) {
                    if(data === "alert"){
                        alertify.alert("At least one image is required for the post.");
                        $("span.deleting-"+postImageId).css("display", "none");
                    }else{
                        $(".post-image-div-"+postImageId).remove();
                    }
                }
            });
        }
    </script>
@stop