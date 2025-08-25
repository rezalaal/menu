<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowTableRequest;
use App\Http\Resources\TableResource;
use App\Models\Table;

class TableController extends Controller
{
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
