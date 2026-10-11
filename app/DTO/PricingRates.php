<?php

namespace App\DTO;

final readonly class PricingRates
{
    public function __construct(
        public float $wastePercent,
        public float $overheadPercent,
        public float $profitPercent,
        public float $taxPercent,
        public int $roundingStep = 1000,
    ) {}
}
