<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\VerificationCodeRequest;
use App\Contracts\Support\Sms;

class VerificationCodesController extends Controller {

    /**
     * 发送验证码
     * @throws \Predis\NotSupportedException
     */
    public function sendCode (VerificationCodeRequest $request, Sms $sms) {
        $phone = $request->phone;

        $code = $this->redisCache()->get('code_'.$phone);
        if(!$code) {
            // 生成4位随机数，左侧补0
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
            $sms->sendSingle($phone, "验证码:".$code);

            //存储到redis， 1分钟
            $this->redisCache()->set('code_'.$phone, $code, 60);
        }

        return response()->json([
            'key'        => 'code_'.$phone,
            'expired_at' => now()->addSeconds(60)->toDateTimeString(),
            'code'       => $code,
        ])->setStatusCode(200);

    }
}
