<?php

namespace App\Support;

use Illuminate\Contracts\Container\Container;
use App\Contracts\Support\Sms as Contracts;

class Sms implements Contracts {
    protected $statusStar =
        [
            "0"  => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词",
        ];

    protected $smsapi = "http://api.smsbao.com/";

    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $app;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    function __construct (Container $container) {
        $this->app = $container;
        $this->config = $container->make('config');
    }

    /**
     * 要钱我就不发了昂
     * @param $phone
     * @param $content
     * @return bool
     */
    public function sendSingle ($phone, $content): bool {
        return true;
    }
}