<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Product;

class CartItemTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $cart = Cart::factory()->create();
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'qty' => 3,
        ]);

        $this->assertEquals($cart->id, $cartItem->cart_id);
        $this->assertEquals($product->id, $cartItem->product_id);
        $this->assertEquals(3, $cartItem->qty);
    }

    public function test_belongs_to_cart(): void
    {
        $cartItem = CartItem::factory()->create();

        $this->assertInstanceOf(Cart::class, $cartItem->cart);
    }

    public function test_belongs_to_product(): void
    {
        $cartItem = CartItem::factory()->create();

        $this->assertInstanceOf(Product::class, $cartItem->product);
    }
}
