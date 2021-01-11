<?php

namespace Akkurate\LaravelAuth\Controllers\Api;

use Akkurate\LaravelCore\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Akkurate\LaravelAuth\Controllers\Back\RegisterController as BackRegisterController;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (! App::environment('testing')) {
            $this->middleware(config('laravel-auth.register_middleware'));
        }
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth::register');
    }

    public function register(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
        return (new BackRegisterController())->register($request);
    }
}
