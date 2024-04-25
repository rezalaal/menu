<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make('همه'),
            'Today' => Tab::make('امروز')
                ->modifyQueryUsing(function($query) {
                    return $query->whereDate('created_at', now()->toDateString());
                }),
            'Yesterday' => Tab::make('دیروز')
                ->modifyQueryUsing(function($query) {
                    return $query->whereDate('created_at', now()->subDay()->toDateString());
                }),
        ];
    }
}
