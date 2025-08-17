<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\ProductResource;

class CategoryProductController extends Controller
{
    public function __invoke($id)
    {
        $category = Category::with('products')->findOrFail($id);

        return ProductResource::collection($category->products);
    }
}
