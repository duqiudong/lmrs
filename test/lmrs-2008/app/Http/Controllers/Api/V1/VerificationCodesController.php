<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\VerificationCodesRequest;
use App\Support\Sms;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;


class VerificationCodesController extends Controller
{
    /**
     * @var string
     * author:六星教育-星空老师
     * 验证码内容的前缀
     */
    protected $temp = "你好，你的验证码是：";

    /**
     * @var
     * author:六星教育-星空老师
     * Redis缓存的key-每个手机号码1分钟内获取短信验证码的次数
     */
    protected $key;

    public function store(VerificationCodesRequest $request,Sms $sms)
    {
        $phone = $request->phone;//获取发送的手机号码

        $this->key = "sms::code:verification::".$phone;
        $phoneNum = $this->phoneNum();
        if (!$phoneNum["restful"]){
            return response()->json($phoneNum);
        }

        $code = str_pad(random_int(1,9999),4,0,STR_PAD_LEFT);

        try{
            //发送短信验证码
//            $restful = $sms->send($phone,$this->temp.$code);
            $restful= "ok";
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

        //定义缓存的key
        $key = 'sms::code::verification::'.$phone."::".str_pad(random_int(1,9999),4,0,STR_PAD_LEFT);

        $exp = now()->addMinutes(3);

        \Cache::put($key,['phone' => $phone,'code' => $code],$exp);

        return response()->json([
            'key' => $key,
            'expired_at' => $exp->toDateTimeString(),
            'restful' => true,
            'message' => $restful,
            'code' => $code//这里为了测试将验证码返回
        ]);
    }

    public function phoneNum()
    {
        try{
            $is_exists = Redis::set($this->key,1,"EX",60,"NX");
            if ($is_exists !=null || Redis::incr($this->key)<=3){
                $restful = [
                    'restful' => true,
                ];
                return $restful;
            }else{
                $restful = [
                    'restful' => false,
                    'message' => '短信验证码获取次数超过了3次，请在1分钟之后再进行尝试'
                ];
                return $restful;
            }
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            $restful = [
                'restful' => false,
                'message' => '系统异常，请稍后在尝试'
            ];
            return $restful;
        }
    }
}
