<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\Table;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@local.tld',
            'password' => 'admin',
            'username' => 'admin'
        ]);
        
        Table::factory(5)->create();

        Category::factory(30)->create();

        $this->call(RawMaterialSeeder::class);

        Product::factory(30)->create();

        $this->createSampleRecipes();
    }

    /**
     * Give some products a formula so the suggested price is calculated.
     */
    private function createSampleRecipes(): void
    {
        $materials = RawMaterial::query()->pluck('id');

        if ($materials->isEmpty()) {
            return;
        }

        Product::query()->take(10)->get()->each(function (Product $product) use ($materials): void {
            $product->rawMaterialRows()->createMany(
                $materials->take(3)->map(fn ($materialId): array => [
                    'raw_material_id' => $materialId,
                    'quantity' => random_int(10, 30),
                ])->all(),
            );
        });
    }
}
