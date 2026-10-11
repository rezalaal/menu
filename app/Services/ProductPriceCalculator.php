<?php

namespace App\Services;

use App\DTO\PriceBreakdown;
use App\DTO\PricingRates;
use App\Enums\PriceSuggestionStatus;
use App\Models\Category;
use App\Models\Product;
use App\Settings\PricingSettings;

class ProductPriceCalculator
{
    public function __construct(
        private readonly PricingSettings $settings,
    ) {}

    /**
     * Calculate the suggested price of a product based on its raw materials.
     *
     * Rates are taken from the product's category, falling back to the
     * global defaults defined in the pricing settings.
     */
    public function calculate(Product $product): ?PriceBreakdown
    {
        $product->loadMissing('rawMaterialRows.rawMaterial');

        $materialCost = $this->materialCost($product);

        return $this->calculateFromCost($product, $materialCost);
    }

    /**
     * Calculate the suggested price of a product and store it on the
     * product together with a suggestion record in the history table.
     */
    public function recalculate(Product $product): ?PriceBreakdown
    {
        $breakdown = $this->calculate($product);

        if ($breakdown === null) {
            $product->forceFill([
                'suggested_price' => null,
                'suggested_price_calculated_at' => now(),
            ])->saveQuietly();

            $this->obsoletePendingSuggestions($product);

            return null;
        }

        $this->persist($product, $breakdown);

        return $breakdown;
    }

    public function rates(?Category $category): PricingRates
    {
        return new PricingRates(
            wastePercent: (float) ($category->waste_percent ?? $this->settings->waste_percent),
            overheadPercent: (float) ($category->overhead_percent ?? $this->settings->overhead_percent),
            profitPercent: (float) ($category->profit_percent ?? $this->settings->profit_percent),
            taxPercent: (float) ($category->tax_percent ?? $this->settings->tax_percent),
            roundingStep: $this->settings->rounding_step,
        );
    }

    /**
     * @return float Total cost of the raw materials of a single product
     */
    public function materialCost(Product $product): float
    {
        return round((float) $product->rawMaterialRows
            ->sum(fn ($row): float => (float) $row->quantity * $row->rawMaterial->unit_price), 2);
    }

    /**
     * Build a price breakdown for the given material cost and product.
     *
     * Product rates are resolved from the product's category, falling back to
     * the global defaults defined in the pricing settings.
     */
    public function calculateFromCost(Product $product, float $materialCost): ?PriceBreakdown
    {
        if ($materialCost <= 0.0) {
            return null;
        }

        return $this->build($product, $this->rates($product->category), $materialCost);
    }

    private function build(Product $product, PricingRates $rates, float $materialCost): PriceBreakdown
    {
        $portions = max(1, (int) ($product->portions ?? 1));
        $perPortionCost = round($materialCost / $portions, 2);

        $wasteAmount = $perPortionCost * $rates->wastePercent / 100;
        $afterWaste = $perPortionCost + $wasteAmount;

        $overheadAmount = $afterWaste * $rates->overheadPercent / 100;
        $afterOverhead = $afterWaste + $overheadAmount;

        $profitAmount = $afterOverhead * $rates->profitPercent / 100;
        $afterProfit = $afterOverhead + $profitAmount;

        $taxAmount = $afterProfit * $rates->taxPercent / 100;

        return new PriceBreakdown(
            materialCost: $materialCost,
            portions: $portions,
            perPortionCost: $perPortionCost,
            wastePercent: $rates->wastePercent,
            overheadPercent: $rates->overheadPercent,
            profitPercent: $rates->profitPercent,
            taxPercent: $rates->taxPercent,
            wasteAmount: round($wasteAmount, 2),
            overheadAmount: round($overheadAmount, 2),
            profitAmount: round($profitAmount, 2),
            taxAmount: round($taxAmount, 2),
            suggestedPrice: $this->round($afterProfit + $taxAmount, $rates->roundingStep),
        );
    }

    private function round(float $value, int $step): int
    {
        if ($step <= 1) {
            return (int) round($value);
        }

        return (int) (round($value / $step) * $step);
    }

    /**
     * Suggestions that were replaced by a new calculation or by a removed
     * recipe can no longer be approved.
     */
    private function obsoletePendingSuggestions(Product $product): void
    {
        $product->priceSuggestions()
            ->where('status', PriceSuggestionStatus::PENDING)
            ->update(['status' => PriceSuggestionStatus::OBSOLETE->value]);
    }

    /**
     * Store a calculated breakdown on the product together with a
     * suggestion record in the history table.
     */
    public function persist(Product $product, PriceBreakdown $breakdown): void
    {
        $product->forceFill([
            'suggested_price' => $breakdown->suggestedPrice,
            'suggested_price_calculated_at' => now(),
        ])->saveQuietly();

        $this->obsoletePendingSuggestions($product);

        $product->priceSuggestions()->create([
            'material_cost' => $breakdown->materialCost,
            'waste_percent' => $breakdown->wastePercent,
            'overhead_percent' => $breakdown->overheadPercent,
            'profit_percent' => $breakdown->profitPercent,
            'tax_percent' => $breakdown->taxPercent,
            'suggested_price' => $breakdown->suggestedPrice,
            'status' => PriceSuggestionStatus::PENDING,
        ]);
    }
}
