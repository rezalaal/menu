<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;

class CategoriesControllerTest extends TestCase
{
    public function test_returns_all_categories_ordered_by_sort_order(): void
    {
        $categoryA = Category::factory()->create(['name' => 'A', 'sort_order' => 2]);
        $categoryB = Category::factory()->create(['name' => 'B', 'sort_order' => 1]);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(2, 'data');

        $this->assertEquals($categoryB->id, $response->json('data.0.id'));
        $this->assertEquals($categoryA->id, $response->json('data.1.id'));
    }

    public function test_includes_product_count(): void
    {
        $category = Category::factory()->create();
        Product::factory()->count(3)->create(['category_id' => $category->id]);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200);
        $this->assertEquals(3, $response->json('data.0.product_count'));
    }

    public function test_returns_empty_when_no_categories(): void
    {
        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }
}
