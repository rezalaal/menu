<?php

namespace Database\Factories;

use App\Models\PriceSuggestion;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PriceSuggestion>
 */
class PriceSuggestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $materialCost = fake()->numberBetween(5000, 50000);

        return [
            'product_id' => Product::factory(),
            'material_cost' => $materialCost,
            'waste_percent' => 3.0,
            'overhead_percent' => 15.0,
            'profit_percent' => 40.0,
            'tax_percent' => 10.0,
            'suggested_price' => round($materialCost * 1.03 * 1.15 * 1.4 * 1.1, -3),
            'status' => 'pending',
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => 'approved',
        ]);
    }
}
