<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

Route::group(['middleware' => 'web'], function() {

    // Authentication Routes...
    Route::get('login', [
        'as' => 'login',
        'uses' => 'Akkurate\LaravelAuth\Controllers\Back\LoginController@showLoginForm'
    ]);
    Route::post('login', [
        'as' => '',
        'uses' => 'Akkurate\LaravelAuth\Controllers\Back\LoginController@login'
    ]);
    Route::match(['get', 'post'], 'logout', [
        'as' => 'logout',
        'uses' => 'Akkurate\LaravelAuth\Controllers\Back\LoginController@logout'
    ]);

    // Password Reset Routes...
    Route::post('password/email', [
        'as' => 'password.email',
        'uses' => 'Akkurate\LaravelAuth\Controllers\Back\ForgotPasswordController@sendResetLinkEmail'
    ]);
    Route::get('password/reset', [
        'as' => 'password.request',
        'uses' => 'Akkurate\LaravelAuth\Controllers\Back\ForgotPasswordController@showLinkRequestForm'
    ]);
    Route::post('password/reset', [
        'as' => 'password.update',
        'uses' => 'Akkurate\LaravelAuth\Controllers\Back\ResetPasswordController@reset'
    ]);
    Route::get('password/reset/{token}', [
        'as' => 'password.reset',
        'uses' => 'Akkurate\LaravelAuth\Controllers\Back\ResetPasswordController@showResetForm'
    ]);

});

