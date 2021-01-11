<?php

namespace Akkurate\LaravelAuth\Controllers\Back;

use Akkurate\LaravelCore\Models\Language;
use Akkurate\LaravelAuth\Notifications\UserRegisteredNotification;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Akkurate\LaravelCore\Models\User;
use Akkurate\LaravelCore\Rules\Firstname;
use Akkurate\LaravelCore\Rules\Lastname;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        if (\Schema::hasColumn('users', 'firstname') && \Schema::hasColumn('users', 'lastname')) {
            return Validator::make($data, [
                'account_id' => 'required|numeric',
                'firstname' => ['required', 'string', 'max:255', new Firstname],
                'lastname' => ['required', 'string', 'max:255', new Lastname],
                'email' => 'required|email|max:255|unique:users',
                'password' => config('laravel-auth.allow_register') ? ['required', 'string', 'min:8', 'confirmed'] : ['nullable'],
            ]);
        } else {
            return Validator::make($data, [
                'account_id' => 'required|numeric',
                'name' => ['required', 'string', 'max:255'],
                'email' => 'required|email|max:255|unique:users',
                'password' => config('laravel-auth.allow_register') ? ['required', 'string', 'min:8', 'confirmed'] : ['nullable'],
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data): User
    {
        if (!\Schema::hasColumn('users', 'firstname') && !\Schema::hasColumn('users', 'lastname')) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => config('laravel-auth.allow_register') ? Hash::make($data['password']) : Hash::make(Str::random(20)),
            ]);
        } else {
            $user = User::create([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'password' => config('laravel-auth.allow_register') ? Hash::make($data['password']) : Hash::make(Str::random(20)),
            ]);
        }

        if (\Schema::hasTable('admin_accounts')) {
            $user->update([
                'account_id' => !empty($data['account_id']) ? $data['account_id'] : auth()->user()->account->id
            ]);
        }

        if (\Schema::hasColumn('users', 'is_active')) {
            $user->update([
                'is_active' => config('laravel-auth.allow_register'),
            ]);
        }

        if (\Schema::hasColumn('users', 'activated_at')) {
            $user->update([
                'activated_at' => Carbon::now(),
            ]);
        }

        if (config('laravel-access') && $role = config('laravel-access.default_role')) {
            $user->assignRole($role);
        }

        if (config('laravel-admin') && \Schema::hasTable('admin_preferences')) {
            $language = Language::where('is_default', true)->first();
            $user->preference()->create([
                'language_id' => $language->id
            ]);
        }

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validatedDatas = $this->validator($request->all())->validated();

        event(new Registered($user = $this->create($validatedDatas)));

        if (config('laravel-auth.allow_register')) {
            $this->guard()->login($user);
        } else {
            $user->update([
                'activation_token' => Str::random(60).'_'.time()
            ]);
            $user->notify(new UserRegisteredNotification($user));
        }

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 201)
            : redirect(config('laravel-core.admin.route'))
                ->withSuccess(config('laravel-auth.allow_register') ? 'Bienvenue !' : 'L’utilisateur a été créé et a reçu un mail de confirmation.');
    }

}
