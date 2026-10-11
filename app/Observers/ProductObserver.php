<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\ProductPriceCalculator;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function saved(Product $product): void
    {
        $this->forgetCatalogCaches();
        $this->recalculateSuggestedPrice($product);
    }

    public function deleted(Product $product): void
    {
        $this->forgetCatalogCaches();
    }

    private function forgetCatalogCaches(): void
    {
        Cache::forget('products_by_category_v2');
        Cache::forget('categories_v2');
    }

    private function recalculateSuggestedPrice(Product $product): void
    {
        if (! $product->wasChanged(['category_id', 'portions'])) {
            return;
        }

        $product->loadMissing('category', 'rawMaterialRows.rawMaterial');

        app(ProductPriceCalculator::class)->recalculate($product);
    }
}
