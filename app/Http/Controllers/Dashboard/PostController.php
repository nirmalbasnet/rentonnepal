<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 30-Nov-20
 * Time: 11:59 PM
 */

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Repositories\PostImageRepository;
use Repositories\PostRepository;

class PostController extends Controller
{
    protected $postRepository, $postImageRepository, $adminAgent = 7;

    public function __construct(PostRepository $postRepository, PostImageRepository $postImageRepository)
    {
        $this->postRepository = $postRepository;
        $this->postImageRepository = $postImageRepository;
    }

    public function index()
    {
        if (Auth::user()->user_type === "admin")
            $posts = $this->postRepository->fetchPost();
        else
            $posts = $this->postRepository->fetchPostByUserId(Auth::id());


        return view("frontend.dashboard.posts.list", compact("posts"));
    }

    public function create()
    {
        return view('frontend.dashboard.posts.form');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "title" => "required",
            "category" => "required",
            "sub_category" => "required",
            "location" => "required",
            "mobile" => "required|digits:10",
            "price" => "required_without:is_negotiable",
            "description" => "required",
            "images" => "required",
            "additional_note" => "max:190"
        ]);

        try {
            if ($request->hasFile('images')) {
                $allowedFileExtension = ['jpeg', 'jpg', 'png', 'bmp'];
                $files = $request->file('images');

                $failed = false;
                $imageValidationFailedMessage = "";

                if (count($files) > 5) {
                    return redirect()->back()->withInput()->withErrors(["images" => "5 images are allowed at most"]);
                }

                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension, $allowedFileExtension);
                    if (!$check) {
                        $imageValidationFailedMessage = "Allowed extensions are png/jpg/jpeg/bmp";
                        $failed = true;
                        break;
                    }

//                    if ($file->getSize() > 2097152) {
//                        $imageValidationFailedMessage = "Allowed size for each image is 2MB max";
//                        $failed = true;
//                        break;
//                    }
                }

                if ($failed && $imageValidationFailedMessage != "") {
                    return redirect()->back()->withInput()->withErrors(["images" => $imageValidationFailedMessage]);
                }
            }

            $post = $request->except("_token", "images");
            $post['slug'] = $this->postRepository->generateSlug($request->title);

            if(Auth::user()->user_type == "admin"){
                $post['user_id'] = $this->adminAgent;
            }else{
                $post["user_id"] = Auth::id();
            }

            DB::beginTransaction();

            if ($post['category'] === "sale")
                $post['price_per'] = null;

            if (isset($request->is_negotiable)){
                $post['price_per'] = null;
                $post["price"] = null;
            }

            if(!Auth::user()->is_profile_completed && Auth::user()->user_type != "admin"){
                if ($request->hasFile('images')) {
                    $files = $request->file('images');
                    $destinationPath = public_path("assets/images/post");

                    foreach ($files as $file) {
                        $ext = $file->getClientOriginalExtension();
                        $fileName = $this->postRepository->generateFileName();
                        $fileName = $fileName . "." . $ext;

                        $img = Image::make($file);
                        $img->resize(770, 560);
                        $img->save($destinationPath."/".$fileName);

                        $post["images"][] = "assets/images/post/$fileName";
                    }
                }

                Session::put("postData", $post);
                return redirect("dashboard/profile/edit")->withError("You must complete your profile first !");
            }

            $createdPost = $this->postRepository->create($post);

            if ($request->hasFile('images')) {
                $files = $request->file('images');
                $destinationPath = public_path("assets/images/post");

                foreach ($files as $file) {
                    $ext = $file->getClientOriginalExtension();
                    $fileName = $this->postRepository->generateFileName();
                    $fileName = $fileName . "." . $ext;

                    $img = Image::make($file);
                    $img->resize(770, 560);
                    $img->save($destinationPath."/".$fileName);

//                    $file->move($destinationPath, $fileName);
                    $postImageData = [
                        "post_id" => $createdPost->id,
                        "image_url" => "assets/images/post/$fileName"
                    ];

                    $this->postImageRepository->create($postImageData);
                }
            }

            DB::commit();

            return redirect("dashboard/posts")->withSuccess("Post created successfully ! It will be published once approved by admin.");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withError('Oops ! something went wrong. Please try later.')->withInput();
        }
    }

    public function edit($id)
    {
        $dataToUpdate = $this->postRepository->findById($id);

        if(Auth::user()->user_type === "admin")
            return view("frontend.dashboard.posts.form", compact("dataToUpdate"));

        if ($dataToUpdate->user_id != Auth::id()) {
            return redirect("dashboard/posts")->withError("You cannot edit others post. Your unauthorized action has been recorded");
        }

        if ($dataToUpdate->published == "Yes") {
            return redirect("dashboard/posts")->withError("You cannot edit published post. Your unauthorized action has been recorded");
        }

        if ($dataToUpdate->status != "Open") {
            return redirect("dashboard/posts")->withError("You can only edit open post. Your unauthorized action has been recorded");
        }

        return view("frontend.dashboard.posts.form", compact("dataToUpdate"));
    }

    public function deletePostImage($imageId)
    {
        $post = $this->postImageRepository->findById($imageId);
        $postImagesCount = $this->postImageRepository->countPostImages($post->post_id);
        if ($postImagesCount == 1) {
            return "alert";
        }

        $this->postImageRepository->delete($imageId);
        return "success";
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            "title" => "required",
            "category" => "required",
            "sub_category" => "required",
            "location" => "required",
            "mobile" => "required|digits:10",
            "price" => "required_without:is_negotiable",
            "description" => "required",
            "additional_note" => "max:190"
        ]);

        try {
            $oldImagesCount = $this->postImageRepository->countPostImages($id);

            $remainingImage = 5 - $oldImagesCount;

            if ($request->hasFile('images')) {
                $allowedFileExtension = ['jpeg', 'jpg', 'png', 'bmp'];
                $files = $request->file('images');

                $failed = false;
                $imageValidationFailedMessage = "";

                if (count($files) > $remainingImage) {
                    return redirect()->back()->withInput()->withErrors(["images" => "Altogether 5 images are allowed at most"]);
                }

                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension, $allowedFileExtension);
                    if (!$check) {
                        $imageValidationFailedMessage = "Allowed extensions are png/jpg/jpeg/bmp";
                        $failed = true;
                        break;
                    }

//                    if ($file->getSize() > 2097152) {
//                        $imageValidationFailedMessage = "Allowed size for each image is 2MB max";
//                        $failed = true;
//                        break;
//                    }
                }

                if ($failed && $imageValidationFailedMessage != "") {
                    return redirect()->back()->withInput()->withErrors(["images" => $imageValidationFailedMessage]);
                }
            } else {
                if ($oldImagesCount == 0)
                    return redirect()->back()->withInput()->withErrors(["images" => "At least one image is required for the post"]);
            }

            $post = $request->except("_token", "images");

            DB::beginTransaction();

            $oldData = $this->postRepository->findById($id);

            if ($oldData->title !== $post['title'])
                $post['slug'] = $this->postRepository->generateSlug($post['title']);

            if ($post['category'] === "sale")
                $post['price_per'] = null;

            if (isset($request->is_negotiable)){
                $post['price_per'] = null;
                $post["price"] = null;
            }else{
                $post["is_negotiable"] = null;
            }

            $this->postRepository->update($id, $post);

            if ($request->hasFile('images')) {
                $files = $request->file('images');
                $destinationPath = public_path("assets/images/post");

                foreach ($files as $file) {
                    $ext = $file->getClientOriginalExtension();
                    $fileName = $this->postRepository->generateFileName();
                    $fileName = $fileName . "." . $ext;

                    $img = Image::make($file);
                    $img->resize(770, 560);
                    $img->save($destinationPath."/".$fileName);
//                    $file->move($destinationPath, $fileName);
                    $postImageData = [
                        "post_id" => $id,
                        "image_url" => "assets/images/post/$fileName"
                    ];

                    $this->postImageRepository->create($postImageData);
                }
            }

            DB::commit();
            return redirect("dashboard/posts")->withSuccess("Post updated successfully !");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withError('Oops ! something went wrong. Please try later.')->withInput();
        }
    }

    public function details($id)
    {
        $detail = $this->postRepository->findById($id);
        return view("frontend.dashboard.posts.details", compact("detail"));
    }

    public function changePublishStatus($postId)
    {
        $newPublishStatus = "Yes";

        $post = $this->postRepository->findById($postId);

        if ($post->published === "Yes")
            $newPublishStatus = "No";

        $this->postRepository->update($postId, [
            "published" => $newPublishStatus
        ]);

        return "success";
    }

    public function changeCategoryStatus($postId)
    {
        $newCategoryStatus = "Rented";

        $post = $this->postRepository->findById($postId);

        if ($post->category === "sale")
            $newCategoryStatus = "Sold";

        if($post->status === "Rented" || $post->status === "Sold")
            $newCategoryStatus = "Open";

        $this->postRepository->update($postId, [
            "status" => $newCategoryStatus
        ]);

        return $newCategoryStatus;
    }
}