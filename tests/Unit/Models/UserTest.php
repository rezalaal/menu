<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Filament\Panel;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => '09121234567',
            'password' => 'secret',
        ]);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals('09121234567', $user->username);
    }

    public function test_hidden_attributes(): void
    {
        $user = User::factory()->create();
        $hidden = $user->getHidden();

        $this->assertContains('password', $hidden);
        $this->assertContains('remember_token', $hidden);
    }

    public function test_password_is_hashed(): void
    {
        $user = User::factory()->create([
            'password' => 'plain-text',
        ]);

        $this->assertNotEquals('plain-text', $user->password);
        $this->assertTrue(Hash::check('plain-text', $user->password));
    }

    public function test_has_cart_relationship(): void
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Cart::class, $user->cart);
        $this->assertEquals($cart->id, $user->cart->id);
    }

    public function test_has_orders_relationship(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->orders->contains($order));
        $this->assertCount(1, $user->orders);
    }

    public function test_has_favorites_relationship(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $user->favorites()->attach($product);

        $this->assertTrue($user->favorites->contains($product));
        $this->assertCount(1, $user->favorites);
    }

    public function test_checkUsername_creates_user_when_not_found(): void
    {
        $username = '09121234567';

        $user = User::checkUsername($username);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($username, $user->username);
        $this->assertEquals($username.'@coralfood.local', $user->email);
        $this->assertNotNull($user->cart);
    }

    public function test_checkUsername_returns_existing_user(): void
    {
        $existing = User::factory()->create(['username' => '09121234567']);
        Cart::factory()->create(['user_id' => $existing->id]);

        $user = User::checkUsername('09121234567');

        $this->assertEquals($existing->id, $user->id);
    }

    public function test_canAccessPanel_with_valid_email(): void
    {
        $panel = Panel::make()->id('admin');

        $user = User::factory()->create([
            'email' => 'admin@local.tld',
            'email_verified_at' => now(),
        ]);

        $this->assertTrue($user->canAccessPanel($panel));
    }

    public function test_canAccessPanel_with_invalid_email_domain(): void
    {
        $panel = Panel::make()->id('admin');

        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
        ]);

        $this->assertFalse($user->canAccessPanel($panel));
    }

    public function test_canAccessPanel_with_unverified_email(): void
    {
        $panel = Panel::make()->id('admin');

        $user = User::factory()->unverified()->create([
            'email' => 'admin@local.tld',
        ]);

        $this->assertFalse($user->canAccessPanel($panel));
    }
}
