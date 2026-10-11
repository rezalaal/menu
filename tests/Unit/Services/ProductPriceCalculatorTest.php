<?php

namespace Tests\Unit\Services;

use App\Settings\PricingSettings;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Services\ProductPriceCalculator;
use App\Services\ProductPriceApprovalService;
use Illuminate\Database\Eloquent\Model;

class ProductPriceCalculatorTest extends TestCase
{
    private ProductPriceCalculator $calculator;

    private ?\App\Models\User $approver = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->calculator = app(ProductPriceCalculator::class);

        app(PricingSettings::class)->fill([
            'waste_percent' => 3.0,
            'overhead_percent' => 15.0,
            'profit_percent' => 40.0,
            'tax_percent' => 10.0,
            'rounding_step' => 1000,
        ])->save();
    }

    private function approver(): \App\Models\User
    {
        return $this->approver ??= \App\Models\User::factory()->create([
            'email' => 'manager@local.tld',
            'email_verified_at' => now(),
        ]);
    }

    public function test_it_calculates_the_suggested_price_of_a_product(): void
    {
        $product = $this->productWithMaterials([
            ['purchase_quantity' => 1000, 'purchase_price' => 500000, 'quantity' => 18],
        ]);

        $breakdown = $this->calculator->calculate($product);

        $this->assertNotNull($breakdown);
        $this->assertEqualsWithDelta(9000.0, $breakdown->materialCost, 0.001);
        $this->assertEqualsWithDelta(270.0, $breakdown->wasteAmount, 0.001);
        $this->assertEqualsWithDelta(1390.5, $breakdown->overheadAmount, 0.001);
        $this->assertEqualsWithDelta(4264.2, $breakdown->profitAmount, 0.001);
        $this->assertEqualsWithDelta(1492.47, $breakdown->taxAmount, 0.001);
        $this->assertSame(16000, $breakdown->suggestedPrice);
    }

    public function test_it_returns_null_for_a_product_without_raw_materials(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertNull($this->calculator->calculate($product));
    }

    public function test_it_divides_the_material_cost_by_the_number_of_portions(): void
    {
        $product = $this->productWithMaterials([
            ['purchase_quantity' => 1000, 'purchase_price' => 500000, 'quantity' => 30],
        ], portions: 3);

        $breakdown = $this->calculator->calculate($product);

        $this->assertNotNull($breakdown);
        $this->assertSame(3, $breakdown->portions);
        $this->assertEqualsWithDelta(15000.0, $breakdown->materialCost, 0.001);
        $this->assertEqualsWithDelta(5000.0, $breakdown->perPortionCost, 0.001);
        $this->assertSame(9000, $breakdown->suggestedPrice);
    }

    public function test_it_uses_the_percentages_of_the_category_when_they_are_set(): void
    {
        $category = Category::factory()->create(['profit_percent' => 50.0]);

        $product = $this->productWithMaterials(
            [['purchase_quantity' => 1000, 'purchase_price' => 500000, 'quantity' => 18]],
            category: $category,
        );

        $rates = $this->calculator->rates($category);

        $this->assertEqualsWithDelta(50.0, $rates->profitPercent, 0.001);
        $this->assertEqualsWithDelta(3.0, $rates->wastePercent, 0.001);
        $this->assertEqualsWithDelta(15.0, $rates->overheadPercent, 0.001);
        $this->assertEqualsWithDelta(10.0, $rates->taxPercent, 0.001);

        $breakdown = $this->calculator->calculate($product);

        $this->assertNotNull($breakdown);
        $this->assertSame(18000, $breakdown->suggestedPrice);
    }

    public function test_it_falls_back_to_the_global_percentages_with_a_category(): void
    {
        $product = $this->productWithMaterials([
            ['purchase_quantity' => 1000, 'purchase_price' => 500000, 'quantity' => 18],
        ]);

        $rates = $this->calculator->rates($product->category);

        $this->assertEqualsWithDelta(3.0, $rates->wastePercent, 0.001);
        $this->assertEqualsWithDelta(15.0, $rates->overheadPercent, 0.001);
        $this->assertEqualsWithDelta(40.0, $rates->profitPercent, 0.001);
        $this->assertEqualsWithDelta(10.0, $rates->taxPercent, 0.001);
    }

    public function test_it_falls_back_to_the_global_percentages_without_a_category(): void
    {
        $rates = $this->calculator->rates(null);

        $this->assertEqualsWithDelta(3.0, $rates->wastePercent, 0.001);
        $this->assertEqualsWithDelta(15.0, $rates->overheadPercent, 0.001);
        $this->assertEqualsWithDelta(40.0, $rates->profitPercent, 0.001);
        $this->assertEqualsWithDelta(10.0, $rates->taxPercent, 0.001);
    }

    public function test_it_rounds_the_suggested_price_to_the_configured_step(): void
    {
        app(PricingSettings::class)->fill(['rounding_step' => 0])->save();

        $product = $this->productWithMaterials([
            ['purchase_quantity' => 1000, 'purchase_price' => 500000, 'quantity' => 18],
        ]);

        $breakdown = $this->calculator->calculate($product);

        $this->assertNotNull($breakdown);
        $this->assertSame((int) round(16417.17), $breakdown->suggestedPrice);
    }

    public function test_recalculate_stores_the_suggested_price_and_a_history_record(): void
    {
        $product = $this->productWithMaterials([
            ['purchase_quantity' => 1000, 'purchase_price' => 500000, 'quantity' => 18],
        ]);

        $breakdown = $this->calculator->recalculate($product);

        $this->assertNotNull($breakdown);
        $this->assertSame(16000, $product->fresh()->suggested_price);
        $this->assertNotNull($product->fresh()->suggested_price_calculated_at);

        $this->assertDatabaseCount('product_price_suggestions', 1);
        $this->assertDatabaseHas('product_price_suggestions', [
            'product_id' => $product->id,
            'suggested_price' => 16000,
            'status' => 'pending',
        ]);
    }

    public function test_recalculating_marks_the_previous_pending_suggestion_as_obsolete(): void
    {
        $product = $this->productWithMaterials([
            ['purchase_quantity' => 1000, 'purchase_price' => 500000, 'quantity' => 18],
        ]);

        $this->calculator->recalculate($product);
        $firstSuggestion = $product->priceSuggestions()->firstOrFail();
        $this->calculator->recalculate($product);

        $this->assertSame('obsolete', $firstSuggestion->fresh()->status->value);
        $this->assertSame(2, $product->priceSuggestions()->count());
        $this->assertSame(1, $product->pendingPriceSuggestions()->count());
    }

    public function test_removing_all_raw_materials_empties_the_suggested_price(): void
    {
        $product = $this->productWithMaterials([
            ['purchase_quantity' => 1000, 'purchase_price' => 500000, 'quantity' => 18],
        ]);

        $this->calculator->recalculate($product);
        $this->assertSame(16000, $product->fresh()->suggested_price);

        $product->rawMaterialRows()->delete();

        $this->calculator->recalculate($product->fresh());

        $this->assertNull($product->fresh()->suggested_price);
    }

    public function test_the_suggested_price_is_applied_to_the_price_field_after_approval(): void
    {
        $product = $this->productWithMaterials([
            ['purchase_quantity' => 1000, 'purchase_price' => 500000, 'quantity' => 18],
        ]);

        $this->calculator->recalculate($product);

        $this->approver();

        $product->refresh()->forceFill(['price' => 10000])->save();

        $this->assertSame(10000, $product->fresh()->price);

        app(ProductPriceApprovalService::class)->approve($product, $this->approver());

        $product = $product->fresh();

        $this->assertSame(16000, $product->price);
        $this->assertNotNull($product->price_approved_at);
        $this->assertSame($this->approver()->id, $product->price_approved_by);

        $this->assertDatabaseHas('product_price_suggestions', [
            'product_id' => $product->id,
            'status' => 'approved',
            'reviewed_by' => $this->approver()->id,
        ]);
    }

    public function test_approving_without_a_pending_suggestion_changes_nothing(): void
    {
        $product = $this->productWithMaterials([
            ['purchase_quantity' => 1000, 'purchase_price' => 500000, 'quantity' => 18],
        ]);

        $this->calculator->recalculate($product);
        app(ProductPriceApprovalService::class)->approve($product, $this->approver());
        $this->assertSame(16000, $product->fresh()->price);

        $product->refresh()->forceFill(['price' => 25000])->save();
        $this->assertNull(app(ProductPriceApprovalService::class)->approve($product, $this->approver()));

        $this->assertSame(25000, $product->fresh()->price);
    }

    public function test_a_rejected_suggestion_is_not_applied_to_the_price(): void
    {
        $product = $this->productWithMaterials([
            ['purchase_quantity' => 1000, 'purchase_price' => 500000, 'quantity' => 18],
        ]);

        $this->calculator->recalculate($product);

        $suggestion = $product->priceSuggestions()->latest('id')->firstOrFail();
        app(ProductPriceApprovalService::class)->reject($suggestion, $this->approver());

        $product->refresh()->forceFill(['price' => 25000])->save();

        $this->assertNull(app(ProductPriceApprovalService::class)->approve($product, $this->approver()));
        $this->assertSame(25000, $product->fresh()->price);
        $this->assertSame('rejected', $suggestion->fresh()->status->value);
    }

    /**
     * @param  array<int, array{purchase_quantity: int|float, purchase_price: int, quantity: int|float}>  $materials
     */
    private function productWithMaterials(array $materials, int $portions = 1, ?Category $category = null): Product
    {
        $product = Product::factory()->create([
            'category_id' => ($category ?? Category::factory()->create())->id,
            'portions' => $portions,
        ]);

        foreach ($materials as $material) {
            $rawMaterial = RawMaterial::factory()->create([
                'purchase_quantity' => $material['purchase_quantity'],
                'purchase_price' => $material['purchase_price'],
            ]);

            Model::withoutEvents(fn () => $product->rawMaterialRows()->create([
                'raw_material_id' => $rawMaterial->id,
                'quantity' => $material['quantity'],
            ]));
        }

        return $product->refresh();
    }
}
