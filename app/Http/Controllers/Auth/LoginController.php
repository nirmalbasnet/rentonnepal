<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\SocialLogin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Repositories\AuthRepository;
use Repositories\SocialLoginRepository;
use Repositories\UserRepository;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $authRepository, $socialLoginRepository, $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthRepository $authRepository, SocialLoginRepository $socialLoginRepository, UserRepository $userRepository)
    {
        $this->authRepository = $authRepository;
        $this->socialLoginRepository = $socialLoginRepository;
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            "email" => "required",
            "password" => "required"
        ]);

        $login = $this->authRepository->login($request->only("email", "password"), $request->remember);

        if (!$login)
            return redirect()->back()->withError('Invalid credential')->withInput();

        if (Auth::user()->status === "Pending") {
            return redirect()->back()->withError('Your account is under processing and will be activated soon.')->withInput();
        }

        if (Auth::user()->status === "Blocked") {
            return redirect()->back()->withError('Your account has been blocked.')->withInput();
        }

        return redirect("dashboard");
    }

    public function socialLogin($socialMedia, Request $request)
    {
        try {
            if($request->session()->has('agent-rating-flash')){
                $request->session()->flash('agent_rating_data_status', $request->session()->get('agent-rating-flash'));
                $request->session()->forget('agent-rating-flash');
            }

            return Socialite::driver($socialMedia)->redirect();
        } catch (\Throwable $e) {
            return redirect("login")->withError('Oops ! something went wrong. Please try later.');
        }
    }

    public function socialLoginRedirect($socialMedia, Request $request)
    {
        try {
            $user = Socialite::driver($socialMedia)->user();

            $id = $user->id;
            $email = $user->email;
            $name = $user->name;

            $checkProviderIdExistence = $this->socialLoginRepository->findByProviderId($id);

            $registeringUserType = "tenant";

            if ($request->session()->has("social-media-login-as") && $request->session()->get("social-media-login-as") === "agent") {
                $registeringUserType = "agent";
            }

            if ($checkProviderIdExistence) {
                $userDetail = $this->userRepository->findById($checkProviderIdExistence->user_id);
            } else {
                $userDetail = $this->userRepository->findByEmail($email);
                if (!$userDetail) {
                    $data = [
                        'name' => $name,
                        'email' => $email,
                        'user_type' => $registeringUserType,
                        'slug' => $this->userRepository->generateSlug($name),
                        'register_type' => $socialMedia,
                        'is_profile_completed' => false,
                        'email_verified_at' => date("Y-m-d h:i:s")
                    ];

                    $userDetail = $this->userRepository->create($data);

                    $userDetail->assignRole($registeringUserType);

                    $this->socialLoginRepository->create([
                        "user_id" => $userDetail->id,
                        "provider_id" => $id,
                        "provider_type" => $socialMedia
                    ]);
                } else {
                    $this->socialLoginRepository->create([
                        "user_id" => $userDetail->id,
                        "provider_id" => $id,
                        "provider_type" => $socialMedia
                    ]);
                }
            }

            if ($userDetail->status === "Pending") {
                if ($registeringUserType === "Agent") {
                    return redirect("become-agent")->withError("Your account has not been activated yet !  Please contact support@rentonnepal.com.");
                } else {
                    return redirect("login")->withError("Your account has not been activated yet ! Please contact support@rentonnepal.com.");
                }
            }

            if ($userDetail->status === "Blocked") {
                if ($registeringUserType === "Agent") {
                    return redirect("become-agent")->withError("Your account has been blocked !  Please contact support@rentonnepal.com.");
                } else {
                    return redirect("login")->withError("Your account has been blocked ! Please contact support@rentonnepal.com.");
                }
            }

            if ($registeringUserType === "agent" && $userDetail->user_type === "tenant") {
                $uniqueToken = $this->userRepository->generateUniqueToken();
                $this->userRepository->update($userDetail->id, ["user_type" => "agent", "unique_token" => $uniqueToken]);
                $userDetail = $this->userRepository->findByid($userDetail->id);
                if (DB::table('model_has_roles')->where('model_id', $userDetail->id)->first()) {
                    DB::table('model_has_roles')->where('model_id', $userDetail->id)->delete();
                }
                $userDetail->assignRole($registeringUserType);

                if (!$userDetail->is_profile_completed){
                    $request->session()->flash('agent_rating_data_status', $request->session()->get('agent_rating_data_status'));
                    return redirect("complete-profile/$userDetail->slug?token=$uniqueToken")->withSuccess("Complete your profile to login.");
                }
            }

            if ($registeringUserType === "tenant" && $userDetail->user_type === "agent") {
                if (!$userDetail->is_profile_completed) {
                    $uniqueToken = $this->userRepository->generateUniqueToken();
                    $this->userRepository->update($userDetail->id, ["unique_token" => $uniqueToken]);
                    $request->session()->flash('agent_rating_data_status', $request->session()->get('agent_rating_data_status'));
                    return redirect("complete-profile/$userDetail->slug?token=$uniqueToken")->withSuccess("Complete your profile to login.");
                }
            }

            if ($userDetail->user_type === "agent") {
                if (!$userDetail->is_profile_completed) {
                    $uniqueToken = $this->userRepository->generateUniqueToken();
                    $this->userRepository->update($userDetail->id, ["unique_token" => $uniqueToken]);
                    $request->session()->flash('agent_rating_data_status', $request->session()->get('agent_rating_data_status'));
                    return redirect("complete-profile/$userDetail->slug?token=$uniqueToken")->withSuccess("Complete your profile to login.");
                }
            }

            Auth::login($userDetail, true);

            if($request->session()->has('agent_rating_data_status')){
                return redirect($request->session()->get('agent_rating_data_status')."?agent-rating");
            }

            return redirect("dashboard");
        } catch (\Throwable $e) {
            return redirect("login")->withError('Oops ! something went wrong. Please try later.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect("/");
    }

    protected function agentSocialLogin($socialMedia, Request $request)
    {
        try {
            $request->session()->flash("social-media-login-as", "agent");
            return Socialite::driver($socialMedia)->redirect();
        } catch (\Throwable $e) {
            return redirect("login")->withError('Oops ! something went wrong. Please try later.');
        }
    }
}
