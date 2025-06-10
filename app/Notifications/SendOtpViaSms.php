<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Spatie\OneTimePasswords\Notifications\OneTimePasswordNotification;

class SendOtpViaSms extends OneTimePasswordNotification
{

    public function via(object $notifiable): string|array
    {
        return ['kavenegar'];
    }


    public function toKavenegar(object $notifiable): array
    {
        return [
            'receptor' => $this->routeNotificationForKavenegar($notifiable),
            'message' => "کد ورود شما:  {$this->password}",
        ];
    }

}
