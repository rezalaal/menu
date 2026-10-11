<?php

namespace Database\Factories;

use App\Enums\MaterialUnit;
use App\Models\RawMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RawMaterial>
 */
class RawMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'base_unit' => MaterialUnit::GRAM,
            'purchase_quantity' => 1000,
            'purchase_price' => fake()->numberBetween(100000, 5000000),
            'is_active' => true,
        ];
    }

    public function unitPrice(int $unitPrice): static
    {
        return $this->state(function (array $attributes) use ($unitPrice): array {
            return [
                'purchase_quantity' => 1000,
                'purchase_price' => $unitPrice * 1000,
            ];
        });
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }
}
