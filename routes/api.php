<?php

Route::group(['middleware' => 'api', 'prefix' => 'api/v1', 'as' => 'api.'], function() {
    // PUBLIC ROUTES
    Route::post('auth/login', 'Akkurate\LaravelAuth\Controllers\Api\LoginController@login')->name('auth.login');
    Route::post('auth/register', 'Akkurate\LaravelAuth\Controllers\Api\RegisterController@register')->name('auth.register');
    Route::post('auth/password/reset', Akkurate\LaravelAuth\Controllers\Api\ForgotPasswordController::class)->name('auth.password.reset');

    // PRIVATE ROUTES
    Route::middleware('auth:api')->group(function () {
        Route::post('auth/logout', 'Akkurate\LaravelAuth\Controllers\Api\LoginController@logout')->name('auth.logout');
        Route::post('auth/{user}/password/update', 'Akkurate\LaravelAuth\Controllers\Api\Password@update')->name('auth.password.update');
    });
});
