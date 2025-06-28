<?php

namespace App\Filament\Resources\UserCustomerResource\Pages;

use App\Filament\Resources\UserCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserCustomers extends ListRecords
{
    protected static string $resource = UserCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
