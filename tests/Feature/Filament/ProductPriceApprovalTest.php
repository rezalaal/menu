<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\User;
use App\Settings\PricingSettings;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Tests\TestCase;

class ProductPriceApprovalTest extends TestCase
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

        $this->actingAs(User::factory()->create([
            'email' => 'admin@local.tld',
            'email_verified_at' => now(),
        ]));

        Filament::setCurrentPanel(Filament::getPanel('admin'));
    }

    public function test_the_suggested_price_is_calculated_when_a_recipe_is_saved(): void
    {
        $product = Product::factory()->create(['price' => 10000]);

        $this->assertNull($product->fresh()->suggested_price);

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->fillForm([
                'rawMaterialRows' => [
                    [
                        'raw_material_id' => $this->rawMaterial(500)->id,
                        'quantity' => 18,
                    ],
                ],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $product = $product->fresh();

        $this->assertEqualsWithDelta(9000.0, (float) $product->suggested_price, 0.001);
        $this->assertSame(1, $product->pendingPriceSuggestions()->count());
    }

    public function test_admin_can_approve_the_suggested_price_of_a_product(): void
    {
        $product = $this->productWithRecipe(price: 10000);

        $this->assertSame(9000, $product->fresh()->suggested_price);
        $this->assertSame(10000, $product->fresh()->price);

        Livewire::test(ListProducts::class)
            ->callTableAction('approve_suggested_price', $product);

        $product = $product->fresh();

        $this->assertSame(9000, $product->price);
        $this->assertNotNull($product->price_approved_at);
        $this->assertSame($this->adminId(), $product->price_approved_by);

        $this->assertDatabaseHas('product_price_suggestions', [
            'product_id' => $product->id,
            'status' => 'approved',
            'reviewed_by' => $this->adminId(),
        ]);
    }

    public function test_the_suggested_prices_of_several_products_can_be_approved_at_once(): void
    {
        $first = $this->productWithRecipe(price: 10000);
        $second = $this->productWithRecipe(price: 20000);

        Livewire::test(ListProducts::class)
            ->callTableBulkAction('approve_suggested_price', [$first, $second]);

        $this->assertSame(9000, $first->fresh()->price);
        $this->assertSame(9000, $second->fresh()->price);
    }

    public function test_a_changed_recipe_updates_the_suggested_price(): void
    {
        $product = $this->productWithRecipe();
        $rawMaterial = $product->rawMaterialRows->firstOrFail()->rawMaterial;

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->fillForm([
                'rawMaterialRows' => [
                    [
                        'raw_material_id' => $rawMaterial->id,
                        'quantity' => 36,
                    ],
                ],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame(18000, $product->fresh()->suggested_price);

        $rawMaterial->update(['purchase_price' => 1000000]);

        $this->assertSame(36000, $product->fresh()->suggested_price);
    }

    public function test_the_suggested_price_is_calculated_from_the_unsaved_form(): void
    {
        $product = $this->productWithRecipe();
        $rawMaterial = $product->rawMaterialRows->firstOrFail()->rawMaterial;

        $this->assertSame(9000, $product->fresh()->suggested_price);
        $this->assertSame('18.0000', $product->rawMaterialRows()->firstOrFail()->quantity);

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->set('data.rawMaterialRows.record-1.quantity', 30)
            ->call('mountFormComponentAction', 'data.recalculate_suggested_priceAction', 'recalculate_suggested_price')
            ->call('callMountedFormComponentAction');

        $this->assertSame(15000, $product->fresh()->suggested_price);
        $this->assertSame('18.0000', $product->fresh()->rawMaterialRows()->firstOrFail()->quantity);
    }

    public function test_the_suggested_price_is_empty_without_raw_materials(): void
    {
        $product = $this->productWithRecipe();
        $product->rawMaterialRows->each->delete();

        $this->assertNull($product->fresh()->suggested_price);
        $this->assertSame(0, $product->pendingPriceSuggestions()->count());
    }

    private function rawMaterial(int $unitPrice): RawMaterial
    {
        return RawMaterial::factory()->create([
            'purchase_quantity' => 1000,
            'purchase_price' => $unitPrice * 1000,
        ]);
    }

    private function productWithRecipe(int $price = 10000, int $quantity = 18): Product
    {
        $product = Product::factory()->create(['price' => $price]);

        $product->rawMaterialRows()->create([
            'raw_material_id' => $this->rawMaterial(500)->id,
            'quantity' => $quantity,
        ]);

        return $product->refresh();
    }

    private function adminId(): int
    {
        return User::firstWhere('email', 'admin@local.tld')->id;
    }
}
