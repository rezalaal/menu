<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductRawMaterial;
use App\Models\RawMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductRawMaterial>
 */
class ProductRawMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'raw_material_id' => RawMaterial::factory(),
            'quantity' => fake()->numberBetween(1, 50),
        ];
    }
}
