<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\OrderLine;
use App\Models\Order;
use App\Models\Product;

class OrderLineTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();
        $orderLine = OrderLine::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'qty' => 2,
            'price' => 75000,
        ]);

        $this->assertEquals($order->id, $orderLine->order_id);
        $this->assertEquals($product->id, $orderLine->product_id);
        $this->assertEquals(2, $orderLine->qty);
        $this->assertEquals(75000, $orderLine->price);
    }

    public function test_belongs_to_order(): void
    {
        $orderLine = OrderLine::factory()->create();

        $this->assertInstanceOf(Order::class, $orderLine->order);
    }

    public function test_belongs_to_product(): void
    {
        $orderLine = OrderLine::factory()->create();

        $this->assertInstanceOf(Product::class, $orderLine->product);
    }
}
