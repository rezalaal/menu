<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class OverviewStats extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('تعداد دسته‌بندی‌ها', Category::count())
                ->description('کل دسته‌بندی‌های ثبت‌شده')
                ->icon('heroicon-o-list-bullet')
                ->color('primary'),

            Card::make('تعداد محصولات', Product::count())
                ->description('کل محصولات ثبت‌شده')
                ->icon('heroicon-o-cube')
                ->color('success'),

            Card::make('تعداد مشتریان', User::count() -1 )
                ->description('کل کاربران  ثبت نام شده')
                ->icon('heroicon-o-user')
                ->color('success'),
        ];
    }
}
