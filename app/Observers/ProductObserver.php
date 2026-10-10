<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function saved(Product $product): void
    {
        $this->forgetCatalogCaches();
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
}
