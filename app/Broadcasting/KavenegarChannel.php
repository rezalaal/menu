<?php

namespace App\Broadcasting;

use Illuminate\Notifications\Notification;

class KavenegarChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toKavenegar')) {
            return;
        }

        $notification->toKavenegar($notifiable);
    }
}
