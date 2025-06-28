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
        $api = new KavenegarApi($apiKey);

        try {
            if ($this->template === 'otp') {
                $api->VerifyLookup($receptor, $this->otp, null, null, $this->template, null);
            } elseif ($this->template === 'welcome') {
                $message = "سلام 😊" . $notifiable->name . " از میزبانی شما خرسندیم\nکافه کورال";
                $api->Send(config('services.kavenegar.sender'), $receptor, $message);
            } else {
                \Log::warning("SendOtpViaSms: Unknown template '{$this->template}' provided.");
                // یا throw new \Exception("Unknown template '{$this->template}' provided.");
            }
        } catch (\Exception $e) {
            \Log::error("SendOtpViaSms: Failed to send SMS. Error: " . $e->getMessage());
        }
    }



}
