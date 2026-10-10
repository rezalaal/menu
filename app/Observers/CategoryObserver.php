<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function saved(Category $category): void
    {
        $this->forgetCatalogCaches();
    }

    public function deleted(Category $category): void
    {
        $this->forgetCatalogCaches();
    }

    private function forgetCatalogCaches(): void
    {
        Cache::forget('products_by_category_v2');
        Cache::forget('categories_v2');
    }
}
