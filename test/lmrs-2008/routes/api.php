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
$api = app('Dingo\Api\Routing\Router');
$api->version('v1',[
    'middleware' => ['bindings'],
    'namespace' => "App\Http\Controllers\Api\V1"
],function ($api){
    $api->post('verificationCodes','VerificationCodesController@store')->name("verificationCodes.store");
    $api->post('users','UserController@store')->name("users.store");
    $api->post('login','UserLoginController@login')->name("login.store");

});
