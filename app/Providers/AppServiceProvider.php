<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Product;
use App\Observers\CategoryObserver;
use App\Observers\ProductObserver;
use App\Observers\ProductRawMaterialObserver;
use App\Observers\RawMaterialObserver;
use App\Models\ProductRawMaterial;
use App\Models\RawMaterial;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Category::observe(CategoryObserver::class);
        Product::observe(ProductObserver::class);
        ProductRawMaterial::observe(ProductRawMaterialObserver::class);
        RawMaterial::observe(RawMaterialObserver::class);
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
