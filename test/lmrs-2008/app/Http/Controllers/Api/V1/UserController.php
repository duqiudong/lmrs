<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserRequest;
use Illuminate\Auth\AuthenticationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $verification_code = \Cache::get($request->verification_key);
        if (!$verification_code){
            abort(403,"验证码已失效");
        }
        if (!hash_equals($verification_code["code"],$request->verification_code)){
            throw new AuthenticationException('验证码错误');
        }
        $user = User::create([
            'name' => $request->name,
            'mobile' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => 1,
            'create_time' => date("Y-m-d H:i:s")
        ]);

        //清除验证码的缓存
        \Cache::forget($request->verification_key);
        return response()->json([
            'restful' => true,
            'message' => "注册成功"
        ]);
    }
}
