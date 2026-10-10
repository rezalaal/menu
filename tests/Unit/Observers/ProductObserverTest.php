<?php

namespace Tests\Unit\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ProductObserverTest extends TestCase
{
    public function test_saved_clears_catalog_caches(): void
    {
        Cache::put('products_by_category_v2', ['cached'], 60);
        Cache::put('categories_v2', ['cached'], 60);

        Product::factory()->create();

        $this->assertFalse(Cache::has('products_by_category_v2'));
        $this->assertFalse(Cache::has('categories_v2'));
    }

    public function test_price_change_clears_catalog_caches(): void
    {
        $product = Product::factory()->create(['price' => 1000]);

        Cache::put('products_by_category_v2', ['cached'], 60);
        Cache::put('categories_v2', ['cached'], 60);

        $product->update(['price' => 2000]);

        $this->assertFalse(Cache::has('products_by_category_v2'));
        $this->assertFalse(Cache::has('categories_v2'));
    }

    public function test_deleted_clears_catalog_caches(): void
    {
        $product = Product::factory()->create();

        Cache::put('products_by_category_v2', ['cached'], 60);
        Cache::put('categories_v2', ['cached'], 60);

        $product->delete();

        $this->assertFalse(Cache::has('products_by_category_v2'));
        $this->assertFalse(Cache::has('categories_v2'));
    }
}
