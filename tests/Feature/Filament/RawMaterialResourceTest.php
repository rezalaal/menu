<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\RawMaterialResource\Pages\CreateRawMaterial;
use App\Filament\Resources\RawMaterialResource\Pages\EditRawMaterial;
use App\Filament\Resources\RawMaterialResource\Pages\ListRawMaterials;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\User;
use App\Settings\PricingSettings;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Tests\TestCase;
use Filament\Support\Exceptions\Halt;

class RawMaterialResourceTest extends TestCase
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

    public function test_it_renders_the_list_page(): void
    {
        $this->assertNotNull(RawMaterial::query()->getModel());

        Livewire::test(ListRawMaterials::class)
            ->assertSuccessful();
    }

    public function test_it_creates_a_raw_material(): void
    {
        Livewire::test(CreateRawMaterial::class)
            ->fillForm([
                'name' => 'شیر پرچرب',
                'base_unit' => 'milliliter',
                'purchase_quantity' => 1000,
                'purchase_price' => 120000,
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $rawMaterial = RawMaterial::firstWhere('name', 'شیر پرچرب');

        $this->assertNotNull($rawMaterial);
        $this->assertEquals('milliliter', $rawMaterial->base_unit->value);
        $this->assertEqualsWithDelta(120.0, $rawMaterial->unit_price, 0.001);
    }

    public function test_the_raw_material_name_must_be_unique(): void
    {
        RawMaterial::factory()->create(['name' => 'قهوه اسپرسو']);

        Livewire::test(CreateRawMaterial::class)
            ->fillForm([
                'name' => 'قهوه اسپرسو',
                'base_unit' => 'gram',
                'purchase_quantity' => 1000,
                'purchase_price' => 500000,
            ])
            ->call('create')
            ->assertHasFormErrors(['name' => 'unique']);

        $this->assertSame(1, RawMaterial::where('name', 'قهوه اسپرسو')->count());
    }

    public function test_it_updates_the_price_of_a_raw_material(): void
    {
        $rawMaterial = RawMaterial::factory()->create([
            'purchase_quantity' => 1000,
            'purchase_price' => 500000,
        ]);

        $product = Product::factory()->create();
        $product->rawMaterialRows()->create([
            'raw_material_id' => $rawMaterial->id,
            'quantity' => 18,
        ]);

        $this->assertSame(9000, $product->fresh()->suggested_price);

        Livewire::test(EditRawMaterial::class, ['record' => $rawMaterial->getRouteKey()])
            ->fillForm(['purchase_price' => 1000000])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertEqualsWithDelta(18000.0, (float) $product->fresh()->suggested_price, 0.001);
    }

    public function test_a_raw_material_used_in_a_product_formula_cannot_be_deleted(): void
    {
        $rawMaterial = RawMaterial::factory()->create();
        $product = Product::factory()->create();

        $product->rawMaterialRows()->create([
            'raw_material_id' => $rawMaterial->id,
            'quantity' => 18,
        ]);

        try {
            Livewire::test(ListRawMaterials::class)
                ->callTableAction('delete', $rawMaterial);
        } catch (Halt) {
            $this->assertTrue($rawMaterial->exists());
        }

        $this->assertDatabaseHas('raw_materials', ['id' => $rawMaterial->id]);
    }

    public function test_an_unused_raw_material_can_be_deleted(): void
    {
        $rawMaterial = RawMaterial::factory()->create();

        Livewire::test(ListRawMaterials::class)
            ->callTableAction('delete', $rawMaterial);

        $this->assertModelMissing($rawMaterial);
    }

    public function test_it_deactivates_a_raw_material(): void
    {
        $rawMaterial = RawMaterial::factory()->create(['is_active' => true]);

        Livewire::test(EditRawMaterial::class, ['record' => $rawMaterial->getRouteKey()])
            ->fillForm(['is_active' => false])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertFalse($rawMaterial->fresh()->is_active);
    }
}
