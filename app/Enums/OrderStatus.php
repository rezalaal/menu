<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasLabel
{    
    case PENDING = "در حال پردازش";
    case WAITING_FOR_CONFIRMATION = "منتظر تایید";
    case PREPARATION = "در حال آماده سازی";
    case CANCELED = "انصراف";
    case SERVING = "در حال سرو";
    case PAID = "پرداخت شده";
    
    public function getLabel(): ?string
    {
        return $this->value;
    }
}
