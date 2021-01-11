<?php

namespace Akkurate\LaravelAuth\Controllers\Back;

use Akkurate\LaravelCore\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth::login');
    }

    protected function sendLoginResponse(Request $request)
    {
        $customRememberMeTimeInMinutes = config('session.remember_me_lifetime');
        $rememberTokenCookieKey = Auth::getRecallerName();
        Cookie::queue($rememberTokenCookieKey, Cookie::get($rememberTokenCookieKey), $customRememberMeTimeInMinutes);
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    public function authenticated($request , $user){
        if ($redirect = config('laravel-access.redirect_user') && $user->hasRole('user')) {
            return redirect()->intended($redirect);
        }
        if (config('laravel-admin.uuid_routing') && $user->account) {
            return redirect()->intended(config('laravel-core.admin.route') . '/' . Auth::user()->account->slug);
        } else {
            return redirect(config('laravel-core.admin.route'));
        }
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect(config('laravel-core.admin.route'));
    }
}
