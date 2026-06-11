<?php

namespace Tests\Feature\Notifications;

use Tests\TestCase;
use App\Models\User;
use App\Notifications\SendOtpViaSms;
use App\Broadcasting\KavenegarChannel;
use Illuminate\Support\Facades\Notification;

class SendOtpViaSmsTest extends TestCase
{
    public function test_notification_sent_via_kavenegar_channel(): void
    {
        $notification = new SendOtpViaSms('12345', 'otp');

        $channels = $notification->via(new User());

        $this->assertCount(1, $channels);
        $this->assertEquals(KavenegarChannel::class, $channels[0]);
    }

    public function test_uses_proper_constructor_values(): void
    {
        $notification = new SendOtpViaSms('98765', 'welcome');

        $this->assertInstanceOf(SendOtpViaSms::class, $notification);
    }

    public function test_to_kavenegar_logs_unknown_template(): void
    {
        $user = User::factory()->create(['username' => '09121234567']);
        $notification = new SendOtpViaSms('12345', 'unknown_template');

        \Illuminate\Support\Facades\Log::shouldReceive('warning')
            ->once()
            ->with("SendOtpViaSms: Unknown template 'unknown_template' provided.");

        $notification->toKavenegar($user);
    }
}
