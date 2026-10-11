<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PriceSuggestionStatus: string implements HasColor, HasLabel
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case OBSOLETE = 'obsolete';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'در انتظار تایید',
            self::APPROVED => 'تایید شده',
            self::REJECTED => 'رد شده',
            self::OBSOLETE => 'منسوخ شده',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
            self::OBSOLETE => 'gray',
        };
    }
}
