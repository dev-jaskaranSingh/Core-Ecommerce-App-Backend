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

//Customer APIs
Route::group(['prefix' => 'customer', 'as' => 'customer'], function () {

    // login user
    Route::post('login-with-password',   'CustomerAuthController@loginUserWithPassword')->name('login.user.password');
    Route::post('login-with-otp',   'CustomerAuthController@loginUserWithOtp')->name('login.user.otp');

    //OTP
    Route::post('send-otp',   'CustomerAuthController@sendOtp')->name('send.otp');
    Route::post('verify-otp',   'CustomerAuthController@verifyOtp')->name('verify.otp');

    //Password Reset
    Route::post('forgot-password',   'CustomerAuthController@forgotPassword')->name('forgot.password');


    //signup user
    Route::post('user/create',   'CustomerAuthController@userRegister')->name('register.user');
});