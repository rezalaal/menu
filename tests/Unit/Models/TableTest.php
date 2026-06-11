<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Table;
use App\Models\Order;

class TableTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $table = Table::factory()->create([
            'name' => 'میز شماره یک',
            'called_waiter' => true,
        ]);

        $this->assertEquals('میز شماره یک', $table->name);
        $this->assertTrue($table->called_waiter);
    }

    public function test_has_orders_relationship(): void
    {
        $table = Table::factory()->create();
        $order = Order::factory()->create(['table_id' => $table->id]);

        $this->assertTrue($table->orders->contains($order));
        $this->assertCount(1, $table->orders);
    }

    public function test_registers_videos_media_collection(): void
    {
        $table = Table::factory()->create();

        $this->assertInstanceOf(\Spatie\MediaLibrary\HasMedia::class, $table);
        $collections = $table->getRegisteredMediaCollections();
        $this->assertCount(1, $collections);
        $this->assertEquals('videos', $collections->first()->name);
    }
}
