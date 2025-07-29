<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function saved(Product $product): void
    {
        Cache::forget('all_products_with_media_and_category');
    }

    public function deleted(Product $product): void
    {
        Cache::forget('all_products_with_media_and_category');
    }
}
