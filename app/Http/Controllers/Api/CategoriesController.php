<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoriesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="لیست دسته‌بندی‌ها",
     *     description="لیست تمام دسته‌بندی‌ها را با تعداد محصولات هر دسته برمی‌گرداند.",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="لیست دسته‌بندی‌ها با موفقیت برگردانده شد.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="قهوه‌ها"),
     *                     @OA\Property(property="product_count", type="integer", example=10)
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function __invoke(Request $request)
    {
        return CategoryResource::collection(
            Category::with('products')->orderBy('sort_order')->get()
        );
    }
}
