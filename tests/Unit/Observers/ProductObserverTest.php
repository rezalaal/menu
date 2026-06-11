<?php

namespace Tests\Unit\Observers;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class ProductObserverTest extends TestCase
{
    public function test_saved_clears_category_products_cache(): void
    {
        $category = Category::factory()->create();
        $cacheKey = "category_products_{$category->id}";

        Cache::put($cacheKey, ['cached'], 60);
        $this->assertTrue(Cache::has($cacheKey));

        Product::factory()->create(['category_id' => $category->id]);

        $this->assertFalse(Cache::has($cacheKey));
    }

    public function test_saved_with_category_change_clears_original_cache(): void
    {
        $oldCategory = Category::factory()->create();
        $newCategory = Category::factory()->create();
        $oldCacheKey = "category_products_{$oldCategory->id}";
        $newCacheKey = "category_products_{$newCategory->id}";

        $product = Product::factory()->create(['category_id' => $oldCategory->id]);

        Cache::put($oldCacheKey, ['cached'], 60);
        Cache::put($newCacheKey, ['cached'], 60);

        $product->update(['category_id' => $newCategory->id]);

        $this->assertFalse(Cache::has($oldCacheKey));
        $this->assertFalse(Cache::has($newCacheKey));
    }

    public function test_deleted_clears_category_products_cache(): void
    {
        $product = Product::factory()->create();
        $cacheKey = "category_products_{$product->category_id}";

        Cache::put($cacheKey, ['cached'], 60);
        $this->assertTrue(Cache::has($cacheKey));

        $product->delete();

        $this->assertFalse(Cache::has($cacheKey));
    }
}
