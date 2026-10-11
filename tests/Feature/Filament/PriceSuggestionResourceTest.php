<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\PriceSuggestionResource\Pages\ListPriceSuggestions;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\User;
use App\Settings\PricingSettings;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Tests\TestCase;

class PriceSuggestionResourceTest extends TestCase
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

    public function test_the_history_page_lists_the_calculated_suggestions(): void
    {
        $product = $this->productWithRecipe();

        $this->assertSame(1, $product->priceSuggestions()->count());

        Livewire::test(ListPriceSuggestions::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords($product->priceSuggestions);
    }

    public function test_a_suggestion_can_be_approved_from_the_history_page(): void
    {
        $product = $this->productWithRecipe();
        $suggestion = $product->priceSuggestions()->latest('id')->firstOrFail();

        $product->refresh()->forceFill(['price' => 10000])->save();

        Livewire::test(ListPriceSuggestions::class)
            ->callTableAction('approve', $suggestion);

        $this->assertSame(9000, $product->fresh()->price);
        $this->assertSame('approved', $suggestion->fresh()->status->value);
        $this->assertNotNull($suggestion->fresh()->reviewed_at);
    }

    public function test_a_suggestion_can_be_rejected_from_the_history_page(): void
    {
        $product = $this->productWithRecipe();
        $suggestion = $product->priceSuggestions()->latest('id')->firstOrFail();

        Livewire::test(ListPriceSuggestions::class)
            ->callTableAction('reject', $suggestion);

        $this->assertSame('rejected', $suggestion->fresh()->status->value);
        $this->assertSame(10000, $product->fresh()->price);
    }

    private function productWithRecipe(): Product
    {
        $product = Product::factory()->create(['price' => 10000]);

        $product->rawMaterialRows()->create([
            'raw_material_id' => RawMaterial::factory()->create([
                'purchase_quantity' => 1000,
                'purchase_price' => 500000,
            ])->id,
            'quantity' => 18,
        ]);

        return $product->refresh();
    }
}
