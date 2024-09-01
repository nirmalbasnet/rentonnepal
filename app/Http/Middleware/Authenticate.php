<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            $loggedInUser = Auth::user();

            if ($loggedInUser->status === "Pending") {
                Auth::logout();
                return redirect("login")->withError('Your account is under processing and will be activated soon.')->withInput();
            }

            if ($loggedInUser->status === "Blocked") {
                Auth::logout();
                return redirect("login")->withError('Your account has been blocked.')->withInput();
            }
        }

        return parent::handle($request, $next, $guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return url('login');
        }
    }
}
