<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Table;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Carbon;
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

            Card::make('تعداد سفارشات', Order::count() -1 )
                ->description('تعداد کل سفارش ها ')
                ->icon('heroicon-o-shopping-bag')
                ->color('success'),
            Card::make('تعداد سفارشات امروز', \App\Models\Order::whereDate('created_at', Carbon::today())->count())
                ->description('تعداد سفارشات ثبت شده در امروز')
                ->icon('heroicon-o-shopping-bag')
                ->color('success'),
            Card::make('تعداد میزها', Table::count() -1 )
                ->description('تعداد میزهای سالن')
                ->icon('heroicon-o-clipboard')
                ->color('success'),
        ];
    }
}
