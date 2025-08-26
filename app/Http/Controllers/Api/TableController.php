<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowTableRequest;
use App\Http\Resources\TableResource;
use App\Models\Table;

class TableController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tables/{id}",
     *     summary="نمایش اطلاعات یک میز",
     *     description="با ارسال شناسه میز، اطلاعات آن برگردانده می‌شود.",
     *     tags={"Tables"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="شناسه میز",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="اطلاعات میز با موفقیت برگردانده شد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="میز شماره یک"),
     *                 @OA\Property(property="called_waiter", type="boolean", example=false),
     *                 @OA\Property(property="image_url", type="string", format="url", example="https://yourdomain.com/images/table1.jpg"),
     *                 @OA\Property(property="video_url", type="string", format="url", example="https://yourdomain.com/videos/coral.mp4")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="میز پیدا نشد.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="میز پیدا نشد.")
     *         )
     *     )
     * )
     */

    public function show(ShowTableRequest $request)
    {
        $id = (int) $request->validated()['id'];

        $table = Table::find($id);

        if (!$table) {
            return response()->json(['message' => 'میز پیدا نشد.'], 404);
        }

        return new TableResource($table);
    }
}
