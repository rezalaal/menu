<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;

class CategoryTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $category = Category::factory()->create([
            'name' => 'قهوه‌ها',
            'sort_order' => 1,
        ]);

        $this->assertEquals('قهوه‌ها', $category->name);
        $this->assertEquals(1, $category->sort_order);
    }

    public function test_has_products_relationship(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertTrue($category->products->contains($product));
        $this->assertCount(1, $category->products);
    }

    public function test_registers_image_media_collection(): void
    {
        $category = Category::factory()->create();

        $this->assertInstanceOf(\Spatie\MediaLibrary\HasMedia::class, $category);
        $collections = $category->getRegisteredMediaCollections();
        $this->assertCount(1, $collections);
        $this->assertEquals('image', $collections->first()->name);
    }
}
