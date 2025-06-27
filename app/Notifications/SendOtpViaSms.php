<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Kavenegar\KavenegarApi;

class SendOtpViaSms extends Notification
{

    public function __construct(protected  $otp, protected $template = 'otp'){}

    public function via(object $notifiable): array
    {
        return [\App\Broadcasting\KavenegarChannel::class];
    }


    public function toKavenegar(object $notifiable)
    {
        $receptor = $notifiable->username;
        $apiKey = config('services.kavenegar.api_key');
        if ($this->template === 'otp') {
            $token = $this->otp;
        }else{
            $token = $notifiable->name;
        }

        $api = new KavenegarApi($apiKey);
        $api->VerifyLookup($receptor, $token, null, null, $this->template, null);
    }

}
