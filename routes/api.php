<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->namespace('api\v1')->name('api.v1.')->group(function () {
    Route::namespace('auth')->group(function () {
        Route::post('currentUser', 'LoginController@currentUser');
        Route::post('login', 'LoginController@login');
        Route::post('login/ldap', 'LoginController@ldapLogin')->name('login.ldap');
        Route::post('logout', 'LoginController@logout');
        Route::post('register', 'RegisterController@register');

        Route::post('password/reset', 'ResetPasswordController@reset');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/confirm', 'ConfirmPasswordController@confirm');

        Route::post('email/resend', 'VerificationController@resend');
        Route::get('email/verify/{id}/{hash}', 'VerificationController@verify');
    });
});
