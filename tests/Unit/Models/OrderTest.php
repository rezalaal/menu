<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Order;
use App\Models\User;
use App\Models\Table;
use App\Models\OrderLine;
use App\Enums\OrderStatus;

class OrderTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $user = User::factory()->create();
        $table = Table::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'table_id' => $table->id,
            'total' => 150000,
            'status' => OrderStatus::PENDING,
        ]);

        $this->assertEquals($user->id, $order->user_id);
        $this->assertEquals($table->id, $order->table_id);
        $this->assertEquals(150000, $order->total);
    }

    public function test_status_is_cast_to_enum(): void
    {
        $order = Order::factory()->create([
            'status' => OrderStatus::PENDING,
        ]);

        $this->assertInstanceOf(OrderStatus::class, $order->status);
        $this->assertEquals(OrderStatus::PENDING, $order->status);
    }

    public function test_belongs_to_user(): void
    {
        $order = Order::factory()->create();

        $this->assertInstanceOf(User::class, $order->user);
    }

    public function test_belongs_to_table(): void
    {
        $order = Order::factory()->create();

        $this->assertInstanceOf(Table::class, $order->table);
    }

    public function test_has_many_order_lines(): void
    {
        $order = Order::factory()->create();
        $orderLine = OrderLine::factory()->create(['order_id' => $order->id]);

        $this->assertTrue($order->orderLines->contains($orderLine));
        $this->assertCount(1, $order->orderLines);
    }
}
