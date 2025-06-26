<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ProductCount;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\CategoryCount;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\OverviewStats::class,
        ];
    }
}
