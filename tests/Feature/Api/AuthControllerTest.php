<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    public function test_send_otp_with_valid_mobile(): void
    {
        $response = $this->postJson('/api/send-otp', [
            'mobile' => '09121234567',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'کد تأیید ارسال شد',
            ])
            ->assertJsonStructure(['message', 'expires_in']);
    }

    public function test_send_otp_with_invalid_mobile_format(): void
    {
        $response = $this->postJson('/api/send-otp', [
            'mobile' => '12345',
        ]);

        $response->assertStatus(422);
    }

    public function test_send_otp_returns_too_soon_for_duplicate_request(): void
    {
        $this->postJson('/api/send-otp', [
            'mobile' => '09121234567',
        ]);

        $response = $this->postJson('/api/send-otp', [
            'mobile' => '09121234567',
        ]);

        $response->assertStatus(429)
            ->assertJson([
                'message' => 'کد تأیید قبلاً ارسال شده است. لطفاً کمی صبر کنید.',
            ]);
    }

    public function test_send_otp_creates_user(): void
    {
        $this->assertDatabaseMissing('users', ['username' => '09121234567']);

        $this->postJson('/api/send-otp', [
            'mobile' => '09121234567',
        ]);

        $this->assertDatabaseHas('users', ['username' => '09121234567']);
    }

    public function test_verify_otp_without_sending_code(): void
    {
        $response = $this->postJson('/api/verify-otp', [
            'mobile' => '09121234567',
            'otp' => '12345',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'کد منقضی شده است. لطفاً دوباره درخواست دهید.',
            ]);
    }

    public function test_verify_otp_with_wrong_code(): void
    {
        $this->postJson('/api/send-otp', [
            'mobile' => '09121234567',
        ]);

        $response = $this->postJson('/api/verify-otp', [
            'mobile' => '09121234567',
            'otp' => '99999',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'کد وارد شده نادرست است.',
            ]);
    }

    public function test_verify_otp_requires_digits_5(): void
    {
        $this->postJson('/api/send-otp', [
            'mobile' => '09121234567',
        ]);

        $response = $this->postJson('/api/verify-otp', [
            'mobile' => '09121234567',
            'otp' => '1234',
        ]);

        $response->assertStatus(422);
    }

    public function test_verify_otp_with_wrong_mobile(): void
    {
        $this->postJson('/api/send-otp', [
            'mobile' => '09121234567',
        ]);

        $otp = session('otp');

        $response = $this->postJson('/api/verify-otp', [
            'mobile' => '09129999999',
            'otp' => (string) $otp['code'],
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'کد وارد شده نادرست است.',
            ]);
    }
}
