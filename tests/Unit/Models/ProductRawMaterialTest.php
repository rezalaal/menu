<?php

namespace Tests\Unit\Models;

use App\Models\PriceSuggestion;
use App\Models\Product;
use App\Models\ProductRawMaterial;
use App\Models\RawMaterial;
use Tests\TestCase;
use App\Enums\PriceSuggestionStatus;

class ProductRawMaterialTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $product = Product::factory()->create();
        $rawMaterial = RawMaterial::factory()->create();

        $row = ProductRawMaterial::factory()->create([
            'product_id' => $product->id,
            'raw_material_id' => $rawMaterial->id,
            'quantity' => 18,
        ]);

        $this->assertEquals($product->id, $row->product_id);
        $this->assertEquals($rawMaterial->id, $row->raw_material_id);
        $this->assertEquals('18.0000', $row->quantity);
    }

    public function test_it_belongs_to_a_product_and_a_raw_material(): void
    {
        $row = ProductRawMaterial::factory()->create();

        $this->assertInstanceOf(Product::class, $row->product);
        $this->assertInstanceOf(RawMaterial::class, $row->rawMaterial);
    }

    public function test_line_cost_is_the_quantity_multiplied_by_the_unit_price(): void
    {
        $rawMaterial = RawMaterial::factory()->create([
            'purchase_quantity' => 1000,
            'purchase_price' => 500000,
        ]);

        $row = new ProductRawMaterial([
            'raw_material_id' => $rawMaterial->id,
            'quantity' => 18,
        ]);

        $this->assertEqualsWithDelta(9000.0, $row->line_cost, 0.001);
    }

    public function test_a_product_cannot_use_the_same_raw_material_twice(): void
    {
        $product = Product::factory()->create();
        $rawMaterial = RawMaterial::factory()->create();

        $product->rawMaterialRows()->create([
            'raw_material_id' => $rawMaterial->id,
            'quantity' => 10,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        $product->rawMaterialRows()->create([
            'raw_material_id' => $rawMaterial->id,
            'quantity' => 20,
        ]);
    }

    public function test_deleting_a_product_deletes_its_raw_material_rows(): void
    {
        $row = ProductRawMaterial::factory()->create();

        $row->product->delete();

        $this->assertDatabaseCount('product_raw_materials', 0);
    }

    public function test_price_suggestion_statuses(): void
    {
        $this->assertEquals('pending', PriceSuggestionStatus::PENDING->value);
        $this->assertEquals('در انتظار تایید', PriceSuggestionStatus::PENDING->getLabel());
        $this->assertEquals('warning', PriceSuggestionStatus::PENDING->getColor());
        $this->assertEquals('success', PriceSuggestionStatus::APPROVED->getColor());
    }

    public function test_a_price_suggestion_belongs_to_a_product(): void
    {
        $product = Product::factory()->create();
        $suggestion = PriceSuggestion::factory()->create(['product_id' => $product->id]);

        $this->assertEquals($product->id, $suggestion->product->id);
    }
}
