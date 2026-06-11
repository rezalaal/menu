<?php

namespace Tests\Unit\Observers;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserverTest extends TestCase
{
    public function test_saved_clears_categories_cache(): void
    {
        Cache::put('categories_with_count', ['cached'], 60);
        $this->assertTrue(Cache::has('categories_with_count'));

        $category = Category::factory()->create();

        $this->assertFalse(Cache::has('categories_with_count'));
    }

    public function test_updated_clears_categories_cache(): void
    {
        $category = Category::factory()->create();

        Cache::put('categories_with_count', ['cached'], 60);
        $this->assertTrue(Cache::has('categories_with_count'));

        $category->update(['name' => 'Updated Name']);

        $this->assertFalse(Cache::has('categories_with_count'));
    }

    public function test_deleted_clears_categories_cache(): void
    {
        $category = Category::factory()->create();

        Cache::put('categories_with_count', ['cached'], 60);
        $this->assertTrue(Cache::has('categories_with_count'));

        $category->delete();

        $this->assertFalse(Cache::has('categories_with_count'));
    }
}
