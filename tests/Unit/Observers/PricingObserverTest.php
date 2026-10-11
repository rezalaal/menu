<?php

namespace Tests\Unit\Observers;

use App\Settings\PricingSettings;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use App\Models\RawMaterial;

class PricingObserverTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        app(PricingSettings::class)->fill([
            'waste_percent' => 0.0,
            'overhead_percent' => 0.0,
            'profit_percent' => 0.0,
            'tax_percent' => 0.0,
            'rounding_step' => 0,
        ])->save();
    }

    public function test_changing_the_price_of_a_raw_material_updates_the_suggested_prices(): void
    {
        $product = $this->productWithMaterial(500);

        $this->assertSame(9000, $product->fresh()->suggested_price);

        $product->rawMaterialRows->firstOrFail()->rawMaterial->update(['purchase_price' => 1000000]);

        $this->assertSame(18000, $product->fresh()->suggested_price);
    }

    public function test_adding_a_raw_material_to_a_product_calculates_the_suggested_price(): void
    {
        $product = Product::factory()->create(['category_id' => Category::factory()->create()->id]);

        $this->assertNull($product->fresh()->suggested_price);

        $product->rawMaterialRows()->create([
            'raw_material_id' => RawMaterial::factory()->create([
                'purchase_quantity' => 1000,
                'purchase_price' => 500000,
            ])->id,
            'quantity' => 18,
        ]);

        $this->assertSame(9000, $product->fresh()->suggested_price);
    }

    public function test_removing_the_last_raw_material_empties_the_suggested_price(): void
    {
        $product = $this->productWithMaterial(500);

        $this->assertSame(9000, $product->fresh()->suggested_price);

        $product->rawMaterialRows->each->delete();

        $this->assertNull($product->fresh()->suggested_price);
    }

    public function test_changing_the_number_of_portions_updates_the_suggested_price(): void
    {
        $product = $this->productWithMaterial(500);

        $this->assertSame(9000, $product->fresh()->suggested_price);

        $product->update(['portions' => 3]);

        $this->assertSame(3000, $product->fresh()->suggested_price);
    }

    public function test_changing_the_category_updates_the_suggested_price(): void
    {
        $category = Category::factory()->create(['profit_percent' => 100]);

        $product = $this->productWithMaterial(500);

        $this->assertSame(9000, $product->fresh()->suggested_price);

        $product->update(['category_id' => $category->id]);

        $this->assertSame(18000, $product->fresh()->suggested_price);
    }

    public function test_changing_the_price_of_a_product_does_not_recalculate_the_suggestion(): void
    {
        $product = $this->productWithMaterial(500);

        $this->assertSame(1, $product->priceSuggestions()->count());

        $product->update(['price' => 10000]);

        $this->assertSame(1, $product->priceSuggestions()->count());
        $this->assertSame(9000, $product->fresh()->suggested_price);
        $this->assertSame(10000, $product->fresh()->price);
    }

    private function productWithMaterial(int $unitPrice): Product
    {
        $product = Product::factory()->create([
            'category_id' => Category::factory()->create()->id,
        ]);

        $product->rawMaterialRows()->create([
            'raw_material_id' => RawMaterial::factory()->create([
                'purchase_quantity' => 1000,
                'purchase_price' => $unitPrice * 1000,
            ])->id,
            'quantity' => 18,
        ]);

        return $product->refresh();
    }
}
