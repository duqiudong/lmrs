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
$apiDingo = app("Dingo\Api\Routing\Router");

$apiDingo->version('v1', function ($api) {
    $api->group(["namespace" => "App\Http\Controllers\Api\V1"], function ($api) {
        $api->post('getCode', 'VerificationCodesController@sendCode');
        $api->post('reg', 'UserController@registered');
    });

    $api->group(["namespace" => "App\Http\Controllers"], function ($api) {
        $api->post('login', 'UserLoginController@login');

    });

});


//
//$api->version('v1',
//    ["middleware" => ['bindings'], "namespace" => "App\Http\Controllers\Api\V1"],
//    function ($api) {
//        $api->post('verificationCodes', 'VerificationCodesController@sendCode')->name('verificationCodes.sendCode');
//        $api->post('member', "MemberController@store")->name("member.store");
//    }
//);



