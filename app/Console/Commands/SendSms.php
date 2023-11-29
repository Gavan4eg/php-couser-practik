<?php

namespace App\Console\Commands;

use App\Services\Sms\SmsSendService;
use Illuminate\Console\Command;

class SendSms extends Command
{
    protected $signature = 'test:test';

    private SmsSendService $smsSendService;

    public function __construct(SmsSendService $smsSendService)
    {
        $this->smsSendService = $smsSendService;

        parent::__construct();
    }


    public function handle()
    {

        $this->smsSendService->sen();

    }
}
