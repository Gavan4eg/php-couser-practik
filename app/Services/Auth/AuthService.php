<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Sms\SmsSendService;
use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class AuthService
{
    /** @var \Illuminate\Redis\Connections\Connection */
    private Connection $redis;
    private SmsSendService $smsSendService;

    public function __construct(SmsSendService $smsSendService)
    {
        $this->redis = Redis::connection();

        $this->smsSendService = $smsSendService;

    }

    public function createUser($phone, $name): void
    {
        $user = User::create([
            'name' => $name,
            'phone' => $phone,
        ]);

        Auth::login($user);
    }

    public function authUser($phone): void
    {
        $user = User::query()->where('phone', $phone)->first();

        Auth::login($user);
    }

    public function initializeUserVerification($phone, $name): void
    {
        $this->storeUserDataInSession($name, $phone);
        $this->smsSendService->send($phone);
    }

    public function validateVerificationCode($phone, $code): bool
    {
        $storedCode = $this->redis->get("sms:{$phone}");

        return $storedCode && $code == $storedCode;
    }

    private function storeUserDataInSession($name, $phone): void
    {
        session()->put(['name' => $name, 'phone' => $phone]);
    }


}
