<?php
/**
 * author:六星教育-星空老师
 */
namespace App\Contracts\Support;

interface Sms
{
    /**
     * 短信验证码发送服务
     * @param $phone  手机号码
     * @param $content 短信发送内容
     * @return mixed
     * author:六星教育-星空老师
     */
    public function send($phone,$content);
}