<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// API: v1 routes URL: domain.tld/api/v1/
Route::prefix('v1')->group(function () {
    // login/register no auth routes
    Route::post('register', 'AuthController@register')->name('user.store');
    Route::post('login', 'AuthController@login')->name('user.login');
    Route::post('forgot', 'Auth\ForgotPasswordController@forgot')->name('user.forgot');
    Route::post('reset', 'Auth\ResetPasswordController@reset')->name('user.reset');

    // authorised routes
    Route::middleware(['auth:api', 'user.status'])->group(function () {
        // user routes URL: domain.tld/api/v1/me/
        Route::prefix('me')->group(function () {
            Route::get('/', 'AuthController@user')->name('user.show');
            Route::post('fcm/token', 'FcmController@token')->name('user.fcm.token');
            Route::post('fcm/subscribe/{$topic}', 'FcmController@subscribe')->name('user.fcm.subscribe');
            Route::post('fcm/unsubscribe/{$topic}', 'FcmController@unsubscribe')->name('user.fcm.unsubscribe');
            Route::put('update', 'AuthController@update')->name('user.update');
            Route::post('deactivate', 'AuthController@deactivate')->name('user.destroy');
        });

        // resource routes URL: domain.tld/api/v1/resource
        //
    });
});
