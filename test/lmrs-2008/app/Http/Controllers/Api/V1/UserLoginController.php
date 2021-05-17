<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserLoginRequest;
use Illuminate\Support\Facades\Redis;
use App\Models\User;

class UserLoginController extends Controller
{
    /**
     * @param UserLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * author:六星教育-星空老师
     * 登录
     */
    public function login(UserLoginRequest $request)
    {
        $UserInfo = $request->only(['name','password']);

        if (!$token = auth('api')->attempt($UserInfo)){
            return response()->json([
                'restful' => false,
                'message' => '账号或者密码错误'
            ]);
        }

        $user  = $this->userinfo();

        $key = "user::info::".$user->original[0]->id;
        Redis::set($key,serialize($user->original[0]),"EX",3600);

        return response()->json([
            'token' => $token,
            'restful' => true,
            'message' => '登录成功'
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * author:六星教育-星空老师
     * 登出
     */
    public function logout($id)
    {
        auth('api')->logout();
        Redis::del("user::info::".$id);
        return response()->json(["message" => "退出成功"]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * author:六星教育-星空老师
     *用户详细信息获取
     */
    public function userinfo()
    {
        return response()->json([auth('api')->user()]);
    }
}
