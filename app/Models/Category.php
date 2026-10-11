<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property float|null $waste_percent
 * @property float|null $overhead_percent
 * @property float|null $profit_percent
 * @property float|null $tax_percent
 */
class Category extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'sort_order',
        'waste_percent',
        'overhead_percent',
        'profit_percent',
        'tax_percent',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }
}
