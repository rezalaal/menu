<?php

namespace Tests\Feature\Filament;

use App\Filament\Pages\ManagePricingSettings;
use App\Filament\Resources\PriceSuggestionResource\Pages\ListPriceSuggestions;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\RawMaterialResource\Pages\CreateRawMaterial;
use App\Filament\Resources\RawMaterialResource\Pages\ListRawMaterials;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Tests\TestCase;

class PricingPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create([
            'email' => 'admin@local.tld',
            'email_verified_at' => now(),
        ]));

        Filament::setCurrentPanel(Filament::getPanel('admin'));
    }

    public function test_the_raw_material_pages_render(): void
    {
        Livewire::test(ListRawMaterials::class)->assertSuccessful();
        Livewire::test(CreateRawMaterial::class)->assertSuccessful();
    }

    public function test_the_product_page_renders_the_raw_material_form(): void
    {
        Livewire::test(CreateProduct::class)
            ->assertSuccessful()
            ->assertFormFieldExists('rawMaterialRows')
            ->assertFormFieldExists('portions')
            ->assertSee('پیش‌نمایش قیمت پیشنهادی');
    }

    public function test_the_price_suggestion_page_renders(): void
    {
        Livewire::test(ListPriceSuggestions::class)->assertSuccessful();
    }

    public function test_the_pricing_settings_page_renders(): void
    {
        Livewire::test(ManagePricingSettings::class)
            ->assertSuccessful()
            ->assertFormSet([
                'waste_percent' => 3.0,
                'overhead_percent' => 15.0,
                'profit_percent' => 40.0,
                'tax_percent' => 10.0,
                'rounding_step' => 1000,
            ]);
    }
}
