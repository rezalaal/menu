<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use App\Models\RawMaterial;
use Tests\TestCase;
use App\Enums\MaterialUnit;

class RawMaterialTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $rawMaterial = RawMaterial::factory()->create([
            'name' => 'قهوه اسپرسو',
            'base_unit' => MaterialUnit::GRAM,
            'purchase_quantity' => 1000,
            'purchase_price' => 500000,
            'notes' => 'خرید عمده',
        ]);

        $this->assertEquals('قهوه اسپرسو', $rawMaterial->name);
        $this->assertEquals(MaterialUnit::GRAM, $rawMaterial->base_unit);
        $this->assertEquals('1000.0000', $rawMaterial->purchase_quantity);
        $this->assertEquals(500000, $rawMaterial->purchase_price);
        $this->assertTrue($rawMaterial->is_active);
    }

    public function test_unit_price_is_calculated_from_the_purchase_details(): void
    {
        $rawMaterial = RawMaterial::factory()->create([
            'purchase_quantity' => 1000,
            'purchase_price' => 500000,
        ]);

        $this->assertEqualsWithDelta(500.0, $rawMaterial->unit_price, 0.001);
    }

    public function test_unit_price_is_zero_when_the_purchase_quantity_is_zero(): void
    {
        $rawMaterial = new RawMaterial([
            'purchase_quantity' => 0,
            'purchase_price' => 500000,
        ]);

        $this->assertEqualsWithDelta(0.0, $rawMaterial->unit_price, 0.001);
    }

    public function test_it_belongs_to_many_product_raw_materials(): void
    {
        $rawMaterial = RawMaterial::factory()->create();
        $product = Product::factory()->create();

        $product->rawMaterialRows()->create([
            'raw_material_id' => $rawMaterial->id,
            'quantity' => 18,
        ]);

        $this->assertEquals($product->id, $rawMaterial->productRawMaterials->first()->product_id);
        $this->assertTrue($rawMaterial->isUsedInProducts());
    }

    public function test_it_is_not_used_in_any_product(): void
    {
        $rawMaterial = RawMaterial::factory()->create();

        $this->assertFalse($rawMaterial->isUsedInProducts());
    }

    public function test_base_unit_labels(): void
    {
        $this->assertEquals('گرم', MaterialUnit::GRAM->getLabel());
        $this->assertEquals('میلی لیتر', MaterialUnit::MILLILITER->getLabel());
        $this->assertEquals('عدد', MaterialUnit::NUMBER->getLabel());
    }
}
