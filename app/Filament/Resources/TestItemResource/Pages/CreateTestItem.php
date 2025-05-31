<?php

namespace App\Filament\Resources\TestItemResource\Pages;

use App\Filament\Resources\TestItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTestItem extends CreateRecord
{
    protected static string $resource = TestItemResource::class;
}
