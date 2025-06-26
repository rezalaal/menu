<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CategoryCount extends BaseWidget
{
    protected function getCards(): array
    {
        return [
//            Card::make('تعداد دسته‌بندی‌ها', Category::count())
//                ->description('کل دسته‌بندی‌های ثبت‌شده')
//                ->icon('heroicon-o-list-bullet')
//                ->color('primary'),
        ];
    }
}
