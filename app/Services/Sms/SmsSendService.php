<?php

namespace App\Services\Sms;

use AllowDynamicProperties;
use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class SmsSendService
{

    private Connection $redis;

    private TurboSmsService $turboSmsService;

    public function __construct(TurboSmsService $turboSmsService)
    {
        $this->redis = Redis::connection();

        $this->turboSmsService = $turboSmsService;
    }


    public function send($phone): void
    {
        $code = $this->generateVerificationCode();
        $this->setVerificationCodeInRedis($phone, $code);
        $this->sendSmsCode($phone, $code);
    }


    private function generateVerificationCode(): int
    {
        return rand(1000, 9999);
    }

    private function setVerificationCodeInRedis(string $phone, int $code)
    {
        $this->redis->set("sms:{$phone}", $code);
        $this->redis->expire("sms:{$phone}", 1000);

//        if (!$this->redis->exists($phone)) {
//            $this->redis->set($phone, $code);
//            if (!$this->redis->expire($phone, 300)) {
//                Log::error("Failed to set expiration for {$phone} in Redis");
//            }
//        } else {
//            $remaining_time = $this->redis->ttl($phone);
//
//            if ($remaining_time >= 0) {
//                Log::info("Code not sent. Next code will be available in {$remaining_time} seconds.");
//                return redirect()->route('auth.login')->with('error', 'Следующий код будет доступен через ' . $remaining_time . ' секунд');
//            }
//
//            $this->redis->set($phone, $code);
//            if (!$this->redis->expire($phone, 300)) {
//                Log::error("Failed to set expiration for {$phone} in Redis");
//            }
//        }
    }

    private function sendSmsCode(string $phone, int $code): void
    {
        $this->turboSmsService->sendSms($phone, $code);
    }


}

