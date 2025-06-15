<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Kavenegar\KavenegarApi;

class SendOtpViaSms extends Notification
{

    public function __construct(protected  $otp){}

    public function via(object $notifiable): array
    {
        return [\App\Broadcasting\KavenegarChannel::class];
    }


    public function toKavenegar(object $notifiable)
    {
        $receptor = $notifiable->username;
        $apiKey = config('services.kavenegar.api_key');
        $token = $this->otp;

        $api = new KavenegarApi($apiKey);
        $api->VerifyLookup($receptor, $token, null, null, 'otp', null);
    }

}
