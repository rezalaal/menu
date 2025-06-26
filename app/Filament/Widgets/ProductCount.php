<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ProductCount extends BaseWidget
{
    protected function getCards(): array
    {
        return [
//            Card::make('تعداد محصولات', Product::count())
//                ->description('کل محصولات ثبت‌شده')
//                ->icon('heroicon-o-cube')
//                ->color('success'),
        ];
    }
}
