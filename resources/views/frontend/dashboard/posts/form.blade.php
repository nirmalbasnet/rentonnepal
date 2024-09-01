@extends("frontend.dashboard.master")

@section('title')
    {{isset($dataToUpdate) ? "Update" : "Create"}} Post
@stop

@section("style")
    <style>
        .post-image-div {
            position: relative;
            border: 1px solid #bbb;
        }

        .post-image-div img {
            display: block;
            margin: 0 auto;
        }

        .post-image-div i {
            position: absolute;
            left: 5px;
            top: 5px;
            cursor: pointer;
            background: darkred;
            padding: 5px;
            color: #fff;
        }

        span.deleting {
            position: absolute;
            top: 0;
            left: 0;
            color: #fff;
            padding: 7px;
            background: darkred;
            display: none;
        }

        .dis-none {
            display: none;
        }

        .price-section {
            position: relative;
            border: 1px solid #ddd;
            padding: 20px;
        }

        .price-section-label {
            position: absolute;
            top: -11px;
            padding: 0 10px;
            background: #fff;
        }

        .hide-price{
            display: none;
        }

        .show-price{
            display: block;
        }
    </style>
@stop

@section("content")
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="display-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{isset($dataToUpdate) ? "Update" : "Create"}} Post</h4>
                    <p class="card-description">
                        <a href="{{url("dashboard/posts")}}">
                            <button type="button" class="btn btn-secondary btn-fw">Back To List</button>
                        </a>
                    </p>
                </div>

                <div class="col-md-8">
                    <form class="forms-sample" method="post" enctype="multipart/form-data"
                          action="{{isset($dataToUpdate) ? url("dashboard/posts/$dataToUpdate->id/update") : url("dashboard/posts/store")}}">
                        @csrf

                        @if(isset($dataToUpdate))
                            @method('patch')
                        @endif

                        @include("partials.flash.flash")

                        <div class="form-group">
                            <label for="title">Title <span class="req">*</span></label>
                            <input required value="{{old("title", @$dataToUpdate->title)}}" type="text" name="title"
                                   class="form-control" id="title" placeholder="Title">
                            @error('title')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category">Category <span class="req">*</span></label>
                            <select onchange="categoryChanged(this.value)" id="category" required
                                    style="border: 1px solid #f3f3f3; color: #000;"
                                    name="category"
                                    class="form-control">
                                <option {{old("category", @$dataToUpdate->category) === "rent" ? "selected" : ""}} value="rent">
                                    Rent
                                </option>
                                <option {{old("category", @$dataToUpdate->category) === "sale" ? "selected" : ""}} value="sale">
                                    Sale
                                </option>
                            </select>
                            @error('sub_category')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sub_category">Sub Category <span class="req">*</span></label>
                            <select id="sub_category" required style="border: 1px solid #f3f3f3; color: #000;"
                                    name="sub_category"
                                    class="form-control">
                                <option {{old("sub_category", @$dataToUpdate->sub_category) === "room" ? "selected" : ""}} value="room">
                                    Room
                                </option>
                                <option {{old("sub_category", @$dataToUpdate->sub_category) === "flat" ? "selected" : ""}} value="flat">
                                    Flat
                                </option>
                                <option {{old("sub_category", @$dataToUpdate->sub_category) === "house" ? "selected" : ""}} value="house">
                                    House
                                </option>
                                <option {{old("sub_category", @$dataToUpdate->sub_category) === "land" ? "selected" : ""}} value="land">
                                    Land
                                </option>
                            </select>
                            @error('sub_category')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="location">Location <span class="req">*</span></label>
                            <input required value="{{old("location", @$dataToUpdate->location)}}" type="text"
                                   name="location"
                                   class="form-control" id="location" placeholder="Location">
                            @error('location')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mobile">Contact Mobile (9#########) <span class="req">*</span></label>
                            <input required value="{{old("mobile", @$dataToUpdate->mobile)}}" type="number"
                                   name="mobile" pattern="^(9)\d{9}$"
                                   class="form-control" id="mobile" placeholder="9#########">
                            @error('mobile')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="additional_mobile">Additional Contact Mobile (9#########)</label>
                            <input value="{{old("additional_mobile", @$dataToUpdate->additional_mobile)}}" type="number"
                                   name="additional_mobile" pattern="^(9)\d{9}$"
                                   class="form-control" id="additional_mobile" placeholder="9#########">
                            @error('additional_mobile')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        @php
                            $ng = old("is_negotiable", @$dataToUpdate->is_negotiable);
                        @endphp

                        <div class="form-group price-section">
                            <label for="price" class="price-section-label">Price (NPR) <span
                                        class="req">*</span></label>

                            <div class="negotiable-section mb-3 mt-2">
                                <div class="custom-control custom-switch">
                                    <input {{isset($ng) ? "checked" : ""}} name="is_negotiable" type="checkbox"
                                           class="custom-control-input" id="negotiable-switch">
                                    <label class="custom-control-label" for="negotiable-switch">Negotiable</label>
                                </div>
                            </div>

                            <div class="price-input-section {{isset($ng) ? 'hide-price' : 'show-price'}}">
                                <input {{!isset($ng) ? "required" : ""}} value="{{old("price", @$dataToUpdate->price)}}" type="number"
                                       name="price"
                                       class="form-control" id="price" placeholder="10000">
                                @error('price')
                                <span class="form-validation-error">{{ $message }}</span>
                                @enderror

                                <div class="price-radio mt-1  {{old("category", @$dataToUpdate->category) === 'sale' ? 'dis-none' : ''}}">
                                    <div class="form-check-inline">
                                        <input {{old("price_per", @$dataToUpdate->price_per) == "weekly" ? "checked" : ""}} class="form-check-input"
                                               type="radio" name="price_per"
                                               id="price_per_1" value="weekly">
                                        <label class="form-check-label mb-0" for="price_per_1">Weekly</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input {{old("price_per", @$dataToUpdate->price_per) == "monthly" ? "checked" : (!isset($dataToUpdate->price_per) ? "checked" : "")}} class="form-check-input"
                                               type="radio" name="price_per"
                                               id="price_per_2" value="monthly">
                                        <label class="form-check-label mb-0" for="price_per_2">Monthly</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input {{old("price_per", @$dataToUpdate->price_per) == "yearly" ? "checked" : ""}} class="form-check-input"
                                               type="radio" name="price_per"
                                               id="price_per_3" value="yearly">
                                        <label class="form-check-label mb-0" for="price_per_3">Yearly</label>
                                    </div>
                                </div>
                            </div>

                            <div class="additional-note-section mt-4">
                                <label for="additional_note">Additional Note (Optional) - Max 190 Characters</label>
                                <input value="{{old("additional_note", @$dataToUpdate->additional_note)}}" type="text"
                                       name="additional_note"
                                       class="form-control" id="additional_note" placeholder="Additional Note (Optional)">

                                @error('additional_note')
                                <span class="form-validation-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description <span class="req">*</span></label>
                            <textarea class="form-control" name="description" id="description" cols="30"
                                      rows="50">{{old("description", @$dataToUpdate->description)}}</textarea>
                            @error('description')
                            <span class="form-validation-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="images">Images <i data-toggle="tooltip" class="fa fa-info-circle"
                                                          title="You can select at most 5 images with extension jpg/jpeg/png/bmp"></i> @if(!isset($dataToUpdate))
                                    <span class="req">*</span>@endif</label>

                            @if(isset($dataToUpdate))
                                <div class="row mb-3">
                                    @foreach($dataToUpdate->postImages as $image)
                                        <div class="col-md-3 mb-3 post-image-div-{{$image->id}}">
                                            <div class="post-image-div" style="height: 150px;">
                                                <img class="img-responsive" src="{{asset($image->image_url)}}"
                                                     alt="{{$dataToUpdate->title}}">
                                                <i onclick="deletePostImage({{$image->id}})" data-toggle="tooltip"
                                                   title="Remove Post Image"
                                                   class="fa fa-trash"></i>
                                                <span class="deleting deleting-{{$image->id}}">deleting ...</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <input id="images" {{!isset($dataToUpdate) ? "required" : ""}} accept="image/*" multiple
                                   type="file"
                                   name="images[]" class="form-control-file">
                            @error('images')
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
        function categoryChanged(value) {
            if (value === "rent") {
                $("div.price-radio").removeClass("dis-none");
            } else {
                $("div.price-radio").addClass("dis-none");
            }
        }

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

        function deletePostImage(postImageId) {
            $("span.deleting-" + postImageId).css("display", "block");

            $.ajax({
                url: baseUrl + "/dashboard/post-image/" + postImageId + "/delete",
                type: "get",
                success: function (data) {
                    if (data === "alert") {
                        alertify.alert("At least one image is required for the post.");
                        $("span.deleting-" + postImageId).css("display", "none");
                    } else {
                        $(".post-image-div-" + postImageId).remove();
                    }
                }
            });
        }

        $("#negotiable-switch").on("change", function(){
           if($(this).is(":checked")){
               $("div.price-input-section").removeClass("show-price").addClass("hide-price");
               $("input[name=price]").attr("required", false);
           }else{
               $("div.price-input-section").removeClass("hide-price").addClass("show-price");
               $("input[name=price]").attr("required", true);
           }
        });
    </script>
@stop