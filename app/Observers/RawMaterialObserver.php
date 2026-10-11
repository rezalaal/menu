<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductRawMaterial;
use App\Models\RawMaterial;
use App\Services\ProductPriceCalculator;

class RawMaterialObserver
{
    public function saved(RawMaterial $rawMaterial): void
    {
        $productIds = ProductRawMaterial::query()
            ->where('raw_material_id', $rawMaterial->getKey())
            ->pluck('product_id');

        if ($productIds->isEmpty()) {
            return;
        }

        Product::query()
            ->with('category', 'rawMaterialRows.rawMaterial')
            ->whereIn('id', $productIds)
            ->each(function (Product $product): void {
                app(ProductPriceCalculator::class)->recalculate($product);
            });
    }

    public function deleted(RawMaterial $rawMaterial): void
    {
        //
    }
}
