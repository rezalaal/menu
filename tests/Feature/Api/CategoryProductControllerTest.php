<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;

class CategoryProductControllerTest extends TestCase
{
    public function test_returns_products_for_category(): void
    {
        $category = Category::factory()->create();
        $products = Product::factory()->count(3)->create(['category_id' => $category->id]);

        $response = $this->getJson("/api/categories/{$category->id}/products");

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(3, 'data');

        foreach ($products as $product) {
            $response->assertJsonFragment(['id' => $product->id]);
        }
    }

    public function test_returns_404_for_nonexistent_category(): void
    {
        $response = $this->getJson('/api/categories/99999/products');

        $response->assertStatus(404);
    }

    public function test_returns_empty_when_category_has_no_products(): void
    {
        $category = Category::factory()->create();

        $response = $this->getJson("/api/categories/{$category->id}/products");

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }
}
