<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Repositories\UserRepository;

class AgentController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $agents = $this->userRepository->paginateAgent(10);
        return view("frontend.dashboard.agents.list", compact("agents"));
    }

    public function create()
    {
        return view("frontend.dashboard.agents.form");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "email" => "required|email|unique:users",
            "mobile" => "required",
            "address" => "required",
            "profile_pic" => "required",
            "password" => "required|min:6",
        ]);

        try {
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

//                if ($file->getSize() > 10485760) {
//                    $imageValidationFailedMessage = "Allowed size for profile pic is 10MB max";
//                    $failed = true;
//                }

//                list($width, $height) = getimagesize($file);

//                if ($width < 400 || $height < 400) {
//                    $imageValidationFailedMessage = "Image dimension should be at least 400 x 400";
//                    $failed = true;
//                }

                if ($failed && $imageValidationFailedMessage != "") {
                    return redirect()->back()->withInput()->withErrors(["profile_pic" => $imageValidationFailedMessage]);
                }

                $destinationPath = public_path("assets/images/profile-pic");

                $ext = $file->getClientOriginalExtension();
                $fileName = $this->userRepository->generateFileName();
                $fileName = $fileName . "." . $ext;

//                $file->move($destinationPath, $fileName);
                $img = Image::make($file);
                $img->resize(400, 400);
                $img->save($destinationPath."/".$fileName);

                $agent['profile_pic'] = "assets/images/profile-pic/$fileName";
            }

            $agent['user_type'] = "agent";
            $agent['slug'] = $this->userRepository->generateSlug($request->name);
            $agent['is_profile_completed'] = true;

            $user = $this->userRepository->create($agent);
            $user->assignRole("agent");

            return redirect("dashboard/agents")->withSuccess("Agent created successfully");
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->back()->withError('Oops ! something went wrong. Please try later.')->withInput();
        }
    }

    public function edit($id)
    {
        $dataToUpdate = $this->userRepository->findById($id);
        return view("frontend.dashboard.agents.form", compact("dataToUpdate"));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "email" => "required|email|unique:users,email,$id",
            "mobile" => "required",
            "address" => "required"
        ]);

        try {
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

//                if ($file->getSize() > 10485760) {
//                    $imageValidationFailedMessage = "Allowed size for profile pic is 10MB max";
//                    $failed = true;
//                }

//                list($width, $height) = getimagesize($file);

//                if ($width < 400 || $height < 400) {
//                    $imageValidationFailedMessage = "Image dimension should be at least 400 x 400";
//                    $failed = true;
//                }

                if ($failed && $imageValidationFailedMessage != "") {
                    return redirect()->back()->withInput()->withErrors(["profile_pic" => $imageValidationFailedMessage]);
                }

                $destinationPath = public_path("assets/images/profile-pic");

                $ext = $file->getClientOriginalExtension();
                $fileName = $this->userRepository->generateFileName();
                $fileName = $fileName . "." . $ext;

//                $file->move($destinationPath, $fileName);
                $img = Image::make($file);
                $img->resize(400, 400);
                $img->save($destinationPath."/".$fileName);

                $agent['profile_pic'] = "assets/images/profile-pic/$fileName";
            }

            $oldData = $this->userRepository->findByid($id);

            if ($request->name != $oldData->name)
                $agent['slug'] = $this->userRepository->generateSlug($request->name);

            if($agent['password'] == null)
                unset($agent['password']);

            $agent['is_profile_completed'] = true;

            $this->userRepository->update($id, $agent);

            //delete profile pic
            if ($request->hasFile('profile_pic') && $oldData->profile_pic) {
                if (file_exists(public_path($oldData->profile_pic)))
                    unlink(public_path($oldData->profile_pic));
            }

            return redirect("dashboard/agents")->withSuccess("Agent updated successfully");
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->back()->withError('Oops ! something went wrong. Please try later.')->withInput();
        }
    }

    public function details($id){
        $detail = $this->userRepository->findByid($id);
        return view("frontend.dashboard.agents.details", compact("detail"));
    }

    public function changeStatus($uid, Request $request){
        $newStatus = $request->{'new-status'};

        $this->userRepository->update($uid, [
           "status" => $newStatus
        ]);

        return $newStatus;
    }
}
