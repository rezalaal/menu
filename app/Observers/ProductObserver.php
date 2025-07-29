<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function saved(Product $product): void
    {
        if ($product->isDirty('category_id')) {
            $original = $product->getOriginal('category_id');
            if ($original) {
                Cache::forget("category_products_{$original}");
            }
        }

        if ($product->category_id) {
            Cache::forget("category_products_{$product->category_id}");
        }
    }


    public function deleted(Product $product): void
    {
        if ($product->category_id) {
            Cache::forget("category_products_{$product->category_id}");
        }
    }
}
