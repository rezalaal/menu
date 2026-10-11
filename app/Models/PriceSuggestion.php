<?php

namespace App\Models;

use App\Enums\PriceSuggestionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $product_id
 * @property string $material_cost
 * @property float $waste_percent
 * @property float $overhead_percent
 * @property float $profit_percent
 * @property float $tax_percent
 * @property string $suggested_price
 * @property PriceSuggestionStatus $status
 * @property Carbon|null $reviewed_at
 * @property int|null $reviewed_by
 * @property-read Product $product
 * @property-read User|null $reviewer
 */
class PriceSuggestion extends Model
{
    use HasFactory;

    protected $table = 'product_price_suggestions';

    protected $fillable = [
        'product_id',
        'material_cost',
        'waste_percent',
        'overhead_percent',
        'profit_percent',
        'tax_percent',
        'suggested_price',
        'status',
        'reviewed_at',
        'reviewed_by',
    ];

    protected function casts(): array
    {
        return [
            'material_cost' => 'decimal:2',
            'suggested_price' => 'decimal:2',
            'status' => PriceSuggestionStatus::class,
            'reviewed_at' => 'datetime',
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
     * @return BelongsTo<User, $this>
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
