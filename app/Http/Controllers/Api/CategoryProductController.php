<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\ProductResource;

class CategoryProductController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/categories/{id}/products",
     *     summary="لیست محصولات یک دسته‌بندی",
     *     description="با ارسال شناسه دسته‌بندی، لیست محصولات آن دسته برگردانده می‌شود.",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="شناسه دسته‌بندی",
     *         required=true,
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="لیست محصولات با موفقیت برگردانده شد.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=10),
     *                     @OA\Property(property="name", type="string", example="قهوه اسپرسو"),
     *                     @OA\Property(property="description", type="string", example="یک قهوه خوش‌عطر و قوی"),
     *                     @OA\Property(property="price", type="number", format="float", example=85000),
     *                     @OA\Property(property="image_url", type="string", example="https://yourdomain.com/images/espresso.jpg")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="دسته‌بندی پیدا نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [Category] 2")
     *         )
     *     )
     * )
     */

    public function __invoke($id)
    {
        $category = Category::with('products')->findOrFail($id);

        return ProductResource::collection($category->products);
    }
}
