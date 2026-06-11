<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'name' => 'اسپرسو',
            'description' => 'قهوه غلیظ',
            'category_id' => $category->id,
            'price' => 85000,
        ]);

        $this->assertEquals('اسپرسو', $product->name);
        $this->assertEquals('قهوه غلیظ', $product->description);
        $this->assertEquals($category->id, $product->category_id);
        $this->assertEquals(85000, $product->price);
    }

    public function test_belongs_to_category(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    public function test_belongs_to_many_favored_by_users(): void
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();
        $product->favoredBy()->attach($user);

        $this->assertTrue($product->favoredBy->contains($user));
        $this->assertCount(1, $product->favoredBy);
    }

    public function test_image_url_accessor_returns_empty_string_when_no_media(): void
    {
        $product = Product::factory()->create();

        $this->assertSame('', $product->image_url);
    }
}
