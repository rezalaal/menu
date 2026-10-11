<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $product_id
 * @property int $raw_material_id
 * @property string $quantity
 * @property-read Product $product
 * @property-read RawMaterial $rawMaterial
 * @property-read float $line_cost
 */
class ProductRawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'raw_material_id',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
        ];
    }

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo<RawMaterial, $this>
     */
    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function getLineCostAttribute(): float
    {
        return round((float) $this->quantity * $this->rawMaterial->unit_price, 2);
    }
}
