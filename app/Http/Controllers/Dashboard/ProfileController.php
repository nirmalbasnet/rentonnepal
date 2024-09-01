<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Repositories\PostImageRepository;
use Repositories\PostRepository;
use Repositories\UserRepository;

class ProfileController extends Controller
{
    protected $userRepository, $postRepository, $postImageRepository;

    public function __construct(UserRepository $userRepository, PostRepository $postRepository, PostImageRepository $postImageRepository)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->postImageRepository = $postImageRepository;
    }

    public function index(){
        $profile = $this->userRepository->findByid(Auth::id());
        return view("frontend.dashboard.profile.view", compact("profile"));
    }

    public function edit(){
        $profile = $this->userRepository->findByid(Auth::id());
        return view("frontend.dashboard.profile.edit", compact("profile"));
    }

    public function update(Request $request){
        $this->validate($request, [
            "name" => "required",
            "mobile" => "required",
            "address" => "required"
        ]);

        $agent = $request->except("_token");

        if ($request->hasFile('profile_pic')) {
            $allowedFileExtension = ['jpeg', 'jpg', 'png', 'bmp'];
            $file = $request->file('profile_pic');

            $failed = false;
            $imageValidationFailedMessage = "";

            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension, $allowedFileExtension);
            if (!$check) {
                $imageValidationFailedMessage = "Allowed extensions are png/jpg/jpeg/bmp";
                $failed = true;
            }
            if ($failed && $imageValidationFailedMessage != "") {
                return redirect()->back()->withInput()->withErrors(["profile_pic" => $imageValidationFailedMessage]);
            }

            $destinationPath = public_path("assets/images/profile-pic");

            $ext = $file->getClientOriginalExtension();
            $fileName = $this->userRepository->generateFileName();
            $fileName = $fileName . "." . $ext;

            $img = Image::make($file);
            $img->resize(400, 400);
            $img->save($destinationPath."/".$fileName);

            $agent['profile_pic'] = "assets/images/profile-pic/$fileName";
        }

        if ($request->name != Auth::user()->name)
            $agent['slug'] = $this->userRepository->generateSlug($request->name);

        $agent['is_profile_completed'] = true;

        $this->userRepository->update(Auth::id(), $agent);

        if(Session::has("postData")){
            $post = Session::get("postData");
            $images = $post["images"];

            unset($post['images']);

            $createdPost = $this->postRepository->create($post);

            foreach ($images as $image) {
                $postImageData = [
                    "post_id" => $createdPost->id,
                    "image_url" => $image
                ];

                $this->postImageRepository->create($postImageData);
            }

            return redirect("dashboard/posts")->withSuccess("Post created successfully ! It will be published once approved by admin.");
        }

        return redirect("dashboard/profile")->withSuccess("Profile updated successfully");
    }
}
