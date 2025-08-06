<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function sendSMS($to, $message)
    {
        Log::info(config('services.twilio.from'));
        try {
            $message = $this->twilio->messages
                ->create($to, // to
                // ->create("+18777804236", // to
                    [
                        'from' => config('services.twilio.from'), // from
                        'body' => $message,
                        // 'body' => "hsdakjfskja",
                    ]
                );
            return $message->sid;
        } catch (\Exception $e) {
            return false;
        }
    }
}
