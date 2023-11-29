<?php

namespace App\Services\Sms;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TurboSmsService
{
    protected string $token;
    protected string $url;
    protected Client $client;

    public function __construct()
    {
        $this->token = 'Basic a4d5358eb7cc70824eb877fefdf6887715ecc70f';
        $this->url = 'https://api.turbosms.ua/message/send.json';
        $this->client = new Client();
    }

    public function sendSms($phone, $message): string
    {
        try {
            $response = $this->client->post($this->url, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => $this->token,
                ],
                'form_params' => $this->arrayParams($phone, $message),
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    private function arrayParams(string $phone, string $message): array
    {
        return [
            'recipients' => [$phone],
            'viber' => ['sender' => 'Zoolux', 'text' => $message],
            'sms' => ['sender' => 'Zoolux', 'text' => $message],
        ];
    }
}
