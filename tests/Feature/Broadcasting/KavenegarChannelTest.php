<?php

namespace Tests\Feature\Broadcasting;

use Tests\TestCase;
use App\Broadcasting\KavenegarChannel;
use App\Models\User;
use App\Notifications\SendOtpViaSms;
use Illuminate\Notifications\Notification;

class KavenegarChannelTest extends TestCase
{
    public function test_send_calls_to_kavenegar_on_notification(): void
    {
        $channel = new KavenegarChannel();
        $user = User::factory()->create(['username' => '09121234567']);
        $notification = $this->getMockBuilder(SendOtpViaSms::class)
            ->setConstructorArgs(['12345', 'otp'])
            ->onlyMethods(['toKavenegar'])
            ->getMock();

        $notification->expects($this->once())
            ->method('toKavenegar')
            ->with($user);

        $channel->send($user, $notification);
    }

    public function test_send_skips_when_to_kavenegar_method_missing(): void
    {
        $channel = new KavenegarChannel();
        $user = User::factory()->create();
        $notification = $this->createMock(Notification::class);

        $notification->expects($this->never())
            ->method($this->anything());

        $channel->send($user, $notification);
    }
}
