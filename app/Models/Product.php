<?php

namespace App\Models;

use App\Enums\PriceSuggestionStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int|null $suggested_price
 * @property int $portions
 * @property Carbon|null $suggested_price_calculated_at
 * @property Carbon|null $price_approved_at
 * @property int|null $price_approved_by
 * @property int $pending_price_suggestions_count
 * @property-read Collection<int, ProductRawMaterial> $rawMaterialRows
 * @property-read Collection<int, PriceSuggestion> $priceSuggestions
 * @property-read Collection<int, PriceSuggestion> $pendingPriceSuggestions
 * @property-read User|null $priceApprovedBy
 */
class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'price',
        'suggested_price',
        'portions',
    ];

    protected function casts(): array
    {
        return [
            'portions' => 'integer',
            'price_approved_at' => 'datetime',
            'suggested_price_calculated_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany<ProductRawMaterial, $this>
     */
    public function rawMaterialRows(): HasMany
    {
        return $this->hasMany(ProductRawMaterial::class);
    }

    /**
     * @return HasMany<PriceSuggestion, $this>
     */
    public function priceSuggestions(): HasMany
    {
        return $this->hasMany(PriceSuggestion::class);
    }

    /**
     * @return HasMany<PriceSuggestion, $this>
     */
    public function pendingPriceSuggestions(): HasMany
    {
        return $this->hasMany(PriceSuggestion::class)
            ->where('status', PriceSuggestionStatus::PENDING->value);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function priceApprovedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'price_approved_by');
    }

    public function favoredBy()
    {
        return $this->belongsToMany(User::class, 'favorite_product_user')->withTimestamps();
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('default');
    }

    public function hasRecipe(): bool
    {
        return $this->rawMaterialRows()->exists();
    }
}
