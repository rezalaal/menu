<?php

namespace Database\Seeders;

use App\Models\RawMaterial;
use Illuminate\Database\Seeder;

class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            ['name' => 'دانه قهوه اسپرسو', 'base_unit' => 'gram', 'purchase_quantity' => 1000, 'purchase_price' => 1800000],
            ['name' => 'شیر پرچرب', 'base_unit' => 'milliliter', 'purchase_quantity' => 1000, 'purchase_price' => 90000],
            ['name' => 'شکر', 'base_unit' => 'gram', 'purchase_quantity' => 1000, 'purchase_price' => 60000],
            ['name' => 'پودر کاکائو', 'base_unit' => 'gram', 'purchase_quantity' => 500, 'purchase_price' => 350000],
            ['name' => 'چای تلخ سیلان', 'base_unit' => 'gram', 'purchase_quantity' => 250, 'purchase_price' => 250000],
            ['name' => 'لیمو و اسید سیتریک', 'base_unit' => 'milliliter', 'purchase_quantity' => 500, 'purchase_price' => 120000],
        ];

        foreach ($materials as $material) {
            RawMaterial::query()->create($material + ['is_active' => true]);
        }
    }
}
