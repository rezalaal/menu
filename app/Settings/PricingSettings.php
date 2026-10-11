<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PricingSettings extends Settings
{
    public float $waste_percent;

    public float $overhead_percent;

    public float $profit_percent;

    public float $tax_percent;

    public int $rounding_step;

    public static function group(): string
    {
        return 'pricing';
    }
}
