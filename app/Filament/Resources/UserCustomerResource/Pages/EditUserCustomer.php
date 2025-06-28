<?php

namespace App\Filament\Resources\UserCustomerResource\Pages;

use App\Filament\Resources\UserCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserCustomer extends EditRecord
{
    protected static string $resource = UserCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
