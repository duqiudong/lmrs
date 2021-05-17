<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\UserLoginRequest;

class UserLoginController extends Controller {
    //

    public function __construct () {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login (UserLoginRequest $request) {
        $userInfo = $request->only('name', 'password');

        if (!$token = auth('api')->attempt($userInfo)) {
            return response()->json([
                "restful" => false,
                "message" => "账号或者密码错误",
            ]);
        }
        //获取用户信息
        $user = $this->userinfo();
        $key = "user::info::".$user->original->id;
        //Redis缓存用户信息3600秒
        $this->redisCache()->set($key, serialize($user->original), 3600);

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(["message" => "退出成功"]);
    }

    public function userinfo () {
        return response()->json(auth('api')->user());
    }

    public function refresh () {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken ($token) {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
            'message'      => '登录成功',
            'restful'      => true,
        ]);
    }
}
