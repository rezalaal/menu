<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductRawMaterial;
use App\Services\ProductPriceCalculator;

class ProductRawMaterialObserver
{
    public function saved(ProductRawMaterial $productRawMaterial): void
    {
        $this->recalculateProduct($productRawMaterial);
    }

    public function deleted(ProductRawMaterial $productRawMaterial): void
    {
        $this->recalculateProduct($productRawMaterial);
    }

    private function recalculateProduct(ProductRawMaterial $productRawMaterial): void
    {
        $product = Product::query()->find($productRawMaterial->product_id);

        if ($product === null) {
            return;
        }

        $product->loadMissing('category', 'rawMaterialRows.rawMaterial');

        app(ProductPriceCalculator::class)->recalculate($product);
    }
}
