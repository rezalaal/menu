<?php

namespace Tests\Unit\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CategoryObserverTest extends TestCase
{
    public function test_saved_clears_catalog_caches(): void
    {
        Cache::put('products_by_category_v2', ['cached'], 60);
        Cache::put('categories_v2', ['cached'], 60);

        Category::factory()->create();

        $this->assertFalse(Cache::has('products_by_category_v2'));
        $this->assertFalse(Cache::has('categories_v2'));
    }

    public function test_updated_clears_catalog_caches(): void
    {
        $category = Category::factory()->create();

        Cache::put('products_by_category_v2', ['cached'], 60);
        Cache::put('categories_v2', ['cached'], 60);

        $category->update(['name' => 'Updated Name']);

        $this->assertFalse(Cache::has('products_by_category_v2'));
        $this->assertFalse(Cache::has('categories_v2'));
    }

    public function test_deleted_clears_catalog_caches(): void
    {
        $category = Category::factory()->create();

        Cache::put('products_by_category_v2', ['cached'], 60);
        Cache::put('categories_v2', ['cached'], 60);

        $category->delete();

        $this->assertFalse(Cache::has('products_by_category_v2'));
        $this->assertFalse(Cache::has('categories_v2'));
    }
}
