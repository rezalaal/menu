<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use App\Models\CartItem;

class CartTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $cart->user_id);
    }

    public function test_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $cart->user);
        $this->assertEquals($user->id, $cart->user->id);
    }

    public function test_has_many_cart_items(): void
    {
        $cart = Cart::factory()->create();
        $cartItem = CartItem::factory()->create(['cart_id' => $cart->id]);

        $this->assertTrue($cart->cartItems->contains($cartItem));
        $this->assertCount(1, $cart->cartItems);
    }

    public function test_create_new_static_method(): void
    {
        $user = User::factory()->create();

        Cart::createNew($user);

        $this->assertDatabaseHas('carts', ['user_id' => $user->id]);
    }
}
