<?php

namespace Akkurate\LaravelAuth\Controllers\Api;

use Akkurate\LaravelCore\Http\Resources\Admin\User as UserResource;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login (Request $request) {

        $login = $request->validate([
            'email' => 'string|required',
            'password' => 'string|required'
        ]);

        if (!Auth::attempt($login)) {
            $response = "Invalid login credentials";
            return response($response, 422);
        }

        return response([
            'user' => new UserResource(Auth::user()),
            'token' => Auth::user()->createToken(Str::lower(Auth::user()->firstname).'_'.Str::lower(Auth::user()->lastname).'_auth_token')->accessToken
        ], 200);

    }

    public function logout (Request $request) {

        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been successfully logged out!';
        return response($response, 200);

    }
}
