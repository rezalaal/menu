<?php

namespace App\Services;

use App\Enums\PriceSuggestionStatus;
use App\Models\PriceSuggestion;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;

class ProductPriceApprovalService
{
    /**
     * Apply the pending suggested price of a product to its real price.
     */
    public function approve(Product $product, ?User $reviewer = null): ?PriceSuggestion
    {
        if (($reviewer = $this->reviewer($reviewer)) === null) {
            return null;
        }

        $suggestion = $this->pendingSuggestion($product);

        if ($suggestion === null) {
            return null;
        }

        $suggestion->forceFill([
            'status' => PriceSuggestionStatus::APPROVED,
            'reviewed_at' => now(),
            'reviewed_by' => $reviewer->getKey(),
        ])->save();

        $product->forceFill([
            'price' => (int) round((float) $suggestion->suggested_price),
            'price_approved_at' => $suggestion->reviewed_at,
            'price_approved_by' => $reviewer->getKey(),
        ])->save();

        return $suggestion;
    }

    /**
     * Approve the suggested prices of several products at once.
     *
     * @param  Collection<int, Product>  $products
     * @return int Number of updated products
     */
    public function approveMany(Collection $products, ?User $reviewer = null): int
    {
        $approved = 0;

        foreach ($products as $product) {
            if ($this->approve($product, $reviewer) !== null) {
                $approved++;
            }
        }

        return $approved;
    }

    public function reject(PriceSuggestion $suggestion, ?User $reviewer = null): void
    {
        if (($reviewer = $this->reviewer($reviewer)) === null) {
            return;
        }

        $suggestion->forceFill([
            'status' => PriceSuggestionStatus::REJECTED,
            'reviewed_at' => now(),
            'reviewed_by' => $reviewer->getKey(),
        ])->save();
    }

    private function reviewer(?User $reviewer): ?User
    {
        if ($reviewer !== null) {
            return $reviewer;
        }

        $user = auth()->user();

        return $user instanceof User ? $user : null;
    }

    private function pendingSuggestion(Product $product): ?PriceSuggestion
    {
        return $product->priceSuggestions()
            ->where('status', PriceSuggestionStatus::PENDING->value)
            ->latest('id')
            ->first();
    }
}
