<?php

namespace App\Filament\Resources\PriceSuggestionResource\Pages;

use App\Filament\Resources\PriceSuggestionResource;
use Filament\Resources\Pages\ListRecords;

class ListPriceSuggestions extends ListRecords
{
    protected static string $resource = PriceSuggestionResource::class;

    public function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    public function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }
}
