<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\RawMaterial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(20)->create();

        $materials = RawMaterial::query()->pluck('id');

        if ($materials->isEmpty()) {
            return;
        }

        $materials->each(function ($materialId): void {
            $product = Product::factory()->create([
                'price' => 0,
                'portions' => fake()->numberBetween(1, 4),
            ]);

            $product->rawMaterialRows()->create([
                'raw_material_id' => $materialId,
                'quantity' => fake()->numberBetween(10, 30),
            ]);
        });
    }
}
