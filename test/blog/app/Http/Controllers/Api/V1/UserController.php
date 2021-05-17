<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function registered(UserRequest $request) {
        $verifyData = $this->redisCache()->get('code_'.$request->phone);
        if(!$verifyData) {
            abort(403, "验证码已失效");
        }

        if(!hash_equals($verifyData, $request->verification_code)) {
            throw new \Exception('验证码错误');
        }

        $member = User::create([
            'name' => $request->name,
            'mobile' => $request->phone,
            'password' => Hash::make($request->password),
            'status'  => 1
        ]);
        return new UserResource($member);
    }
}
