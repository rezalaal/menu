<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MaterialUnit: string implements HasLabel
{
    case GRAM = 'gram';
    case MILLILITER = 'milliliter';
    case NUMBER = 'number';

    public function getLabel(): string
    {
        return match ($this) {
            self::GRAM => 'گرم',
            self::MILLILITER => 'میلی لیتر',
            self::NUMBER => 'عدد',
        };
    }
}
