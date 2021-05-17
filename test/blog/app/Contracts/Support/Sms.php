<?php

namespace App\Contracts\Support;

/**
 * 消息体
 * Interface Sms
 * @package App\Contracts\Support
 */
interface Sms {
    /**
     * 发送单体消息
     * @param $content
     * @param $phone
     * @return mixed
     */
    public function sendSingle ($phone, $content): bool;
}