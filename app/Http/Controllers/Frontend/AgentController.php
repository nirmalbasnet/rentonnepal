<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Repositories\AgentRatingRepository;
use Repositories\PostRepository;
use Repositories\UserRepository;
use View;

class AgentController extends Controller
{
    protected $agentRepository, $postRepository, $agentRatingRepository;

    public function __construct(UserRepository $agentRepository, PostRepository $postRepository, AgentRatingRepository $agentRatingRepository)
    {
        $this->agentRepository = $agentRepository;
        $this->postRepository = $postRepository;
        $this->agentRatingRepository = $agentRatingRepository;
    }

    public function becomeAgent(Request $request)
    {
//        if ($request->method() === "GET")
//            return view('register');
//
//        $this->validate($request, [
//            "name" => "required",
//            "email" => "required|email|unique:users",
//            "mobile" => "required",
//            "address" => "required",
//            "profile_pic" => "required",
//            "password" => "required|min:6",
//        ]);
//
        try {
            if (Auth::check()) {
                $userDetail = Auth::user();
                if ($userDetail->user_type === "agent") {
                    if ($userDetail->is_profile_completed)
                        return redirect("dashboard");
                    else {
                        $uniqueToken = $this->agentRepository->generateUniqueToken();
                        $this->agentRepository->update($userDetail->id, ["unique_token" => $uniqueToken]);
                        Auth::logout();
                        return redirect("complete-profile/$userDetail->slug?token=$uniqueToken")->withSuccess("You have been logged out! Complete your profile to login as agent.");
                    }
                } elseif ($userDetail->user_type === "admin")
                    return redirect("dashboard");
                else {
                    if ($userDetail->is_profile_completed) {
                        $this->agentRepository->update($userDetail->id, ["user_type" => "agent"]);

                        if (DB::table('model_has_roles')->where('model_id', $userDetail->id)->first()) {
                            DB::table('model_has_roles')->where('model_id', $userDetail->id)->delete();
                        }

                        $userDetail->assignRole("agent");

                        return redirect("dashboard")->withSuccess("Your account has been successfully upgraded to agent.");
                    } else {
                        $uniqueToken = $this->agentRepository->generateUniqueToken();
                        $this->agentRepository->update($userDetail->id, ["user_type" => "agent", "unique_token" => $uniqueToken]);

                        if (DB::table('model_has_roles')->where('model_id', $userDetail->id)->first()) {
                            DB::table('model_has_roles')->where('model_id', $userDetail->id)->delete();
                        }
                        $userDetail->assignRole("agent");
                        Auth::logout();
                        return redirect("complete-profile/$userDetail->slug?token=$uniqueToken")->withSuccess("You have been logged out! Complete your profile to login as agent.");
                    }
                }
            }
            return view('ui.login');
//            $agent = $request->except("_token");
//
//            if ($request->hasFile('profile_pic')) {
//                $allowedFileExtension = ['jpeg', 'jpg', 'png', 'bmp'];
//                $file = $request->file('profile_pic');
//
//                $failed = false;
//                $imageValidationFailedMessage = "";
//
//                $extension = $file->getClientOriginalExtension();
//                $check = in_array($extension, $allowedFileExtension);
//                if (!$check) {
//                    $imageValidationFailedMessage = "Allowed extensions are png/jpg/jpeg/bmp";
//                    $failed = true;
//                }
//
//                if ($file->getSize() > 2097152) {
//                    $imageValidationFailedMessage = "Allowed size for profile pic is 2MB max";
//                    $failed = true;
//                }
//
//                list($width, $height) = getimagesize($file);
//
////                if ($width < 400 || $height < 400) {
////                    $imageValidationFailedMessage = "Image dimension should be at least 400 x 400";
////                    $failed = true;
////                }
//
//
//                if ($failed && $imageValidationFailedMessage != "") {
//                    return redirect()->back()->withInput()->withErrors(["profile_pic" => $imageValidationFailedMessage]);
//                }
//
//                $destinationPath = public_path("assets/images/profile-pic");
//
//                $ext = $file->getClientOriginalExtension();
//                $fileName = $this->agentRepository->generateFileName();
//                $fileName = $fileName . "." . $ext;
//
//                $file->move($destinationPath, $fileName);
////                $img = Image::make($file);
////                $img->resize(400, 400);
////                $img->save($destinationPath."/".$fileName);
//                $agent['profile_pic'] = "assets/images/profile-pic/$fileName";
//            }
//
//            $agent['user_type'] = "agent";
//            $agent['status'] = "Pending";
//            $agent['slug'] = $this->agentRepository->generateSlug($request->name);
//
//            $user = $this->agentRepository->create($agent);
//            $user->assignRole("agent");
//
//            return redirect()->back()->withSuccess("You have been registered successfully. Your account will be verified by our team and contact you soon.");
        } catch (\Throwable $e) {
            return redirect()->back()->withError('Oops ! something went wrong. Please try later.')->withInput();
        }
    }

    public function detail($slug)
    {
        $agent = $this->agentRepository->findBySlug($slug);
        $totalDeals = $this->postRepository->totalDeals($agent->id);

        $userAgentRate = null;

        if (Auth::check())
            $userAgentRate = $this->agentRatingRepository->findByAgentAndUser($agent->id, Auth::id());

        $ratings = $this->agentRatingRepository->paginateAgentRating($agent->id, 10);

        return view("ui.agent-detail", compact("agent", "totalDeals", "userAgentRate", "ratings"));
    }

    public function loadMoreRating($agentId){
        $ratings = $this->agentRatingRepository->paginateAgentRating($agentId, 10);
        return View::make("ui.load-more-rating", compact("ratings"))->render();
    }

    public function index()
    {
        $agents = $this->agentRepository->agents(9);
        return view("ui.agents", compact("agents"));
    }

    public function agentProperties($slug)
    {
        $agent = $this->agentRepository->findBySlug($slug);
        $posts = $this->postRepository->agentPublishedProperties($agent, 9);
        return view("ui.agent-properties", compact("agent", "posts"));
    }

    public function completeProfile($slug, Request $request)
    {
        if ($request->method() === "GET") {
            if (!isset($request->token))
                return redirect("invalid-request")->with("error-message", "Oops! Token missing on request");

            $token = $request->token;
            $user = $this->agentRepository->findUserBySlugAndToken($slug, $token);

            $redirectUrl = null;

            if (!$user)
                return redirect("invalid-request")->with("error-message", "invalid request");

            if ($request->session()->has('agent_rating_data_status')) {
                $redirectUrl = $request->session()->get('agent_rating_data_status');
            }

            return view("ui.complete-profile", compact("user", "redirectUrl"));
        }

        $user = $this->agentRepository->findBySlug($slug);

        if (!$user)
            return redirect("invalid-request")->with("error-message", "invalid request");

        $this->validate($request, [
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
            $fileName = $this->agentRepository->generateFileName();
            $fileName = $fileName . "." . $ext;

            $img = Image::make($file);
            $img->resize(400, 400);
            $img->save($destinationPath . "/" . $fileName);

            $agent['profile_pic'] = "assets/images/profile-pic/$fileName";
        }

        $agent['is_profile_completed'] = true;
        $agent['unique_token'] = null;

        $redirectUrl = null;

        if(isset($agent['redirectUrl'])){
            $redirectUrl = $agent['redirectUrl'];
            unset($agent['redirectUrl']);
        }

        $this->agentRepository->update($user->id, $agent);

        $user = $this->agentRepository->findByid($user->id);

        Auth::login($user, true);

        if($redirectUrl)
            return redirect($redirectUrl."?agent-rating")->withReviewInfo("You have successfully logged in. Now you can rate the agent.");

        return redirect("dashboard");
    }

    public function invalidRequest(Request $request)
    {
        if (!$request->session()->has("error-message"))
            return redirect('/');

        $errorMessage = $request->session()->get("error-message");

        $message = "Oops ! The page you are looking for has been expired.";
        $code = 410;

        if ($errorMessage === "Oops! Token missing on request") {
            $code = 499;
            $message = "Invalid Request ! Token expected on request was not found.";
        }

        if ($errorMessage === "invalid request") {
            $code = 403;
            $message = "Unauthorized Request ! The request seems to be unauthorized.";
        }

        return view("ui.invalid-request", compact("message", "code"));
    }

    public function agentReviewSubmit($slug, Request $request)
    {
        $data = $request->except("_token");

        $agent = $this->agentRepository->findBySlug($slug);

        if ($agent) {
            $data['agent_id'] = $agent->id;
            $data['rate'] = $data['star_count'] + 1;
            unset($data['star_count']);
            if (Auth::guest()) {
                $request->session()->put("agentRatingData", $data);
                return redirect("login")->withAgentRatingDataStatus("Please login to save your review.");
            } else {
                $data['user_id'] = Auth::id();
                $this->agentRatingRepository->createOrUpdate($data);
                return redirect("agents/$agent->slug")->withReviewSuccess("Your review was successfully submitted and will be published shortly.");
            }
        }

        return redirect("agents/$agent->slug")->withReviewError("Process couldn't be completed. Please try later.");
    }
}
