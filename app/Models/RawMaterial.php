<?php

namespace App\Models;

use App\Enums\MaterialUnit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property MaterialUnit $base_unit
 * @property string $purchase_quantity
 * @property int $purchase_price
 * @property string|null $notes
 * @property bool $is_active
 * @property-read float $unit_price
 * @property-read Collection<int, ProductRawMaterial> $productRawMaterials
 */
class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_unit',
        'purchase_quantity',
        'purchase_price',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'base_unit' => MaterialUnit::class,
            'purchase_quantity' => 'decimal:4',
            'purchase_price' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return HasMany<ProductRawMaterial, $this>
     */
    public function productRawMaterials(): HasMany
    {
        return $this->hasMany(ProductRawMaterial::class);
    }

    public function getUnitPriceAttribute(): float
    {
        $quantity = (float) $this->purchase_quantity;

        if ($quantity <= 0.0) {
            return 0.0;
        }

        return round((float) $this->purchase_price / $quantity, 2);
    }

    public function isUsedInProducts(): bool
    {
        return $this->productRawMaterials()->exists();
    }
}
