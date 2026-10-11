<?php

namespace App\DTO;

final readonly class PriceBreakdown
{
    public function __construct(
        public float $materialCost,
        public int $portions,
        public float $perPortionCost,
        public float $wastePercent,
        public float $overheadPercent,
        public float $profitPercent,
        public float $taxPercent,
        public float $wasteAmount,
        public float $overheadAmount,
        public float $profitAmount,
        public float $taxAmount,
        public int $suggestedPrice,
    ) {}

    /**
     * Lines shown in the panel when a suggested price is calculated.
     *
     * @return array<string, string>
     */
    public function toDisplayLines(): array
    {
        return [
            'هزینه مواد اولیه' => $this->materialCost.' تومان',
            'تعداد پرس' => (string) $this->portions,
            'هزینه هر پرس' => $this->perPortionCost.' تومان',
            'ریخت و پاش ('.$this->wastePercent.'%)' => $this->wasteAmount.' تومان',
            'سربار و دستمزد ('.$this->overheadPercent.'%)' => $this->overheadAmount.' تومان',
            'حاشیه سود ('.$this->profitPercent.'%)' => $this->profitAmount.' تومان',
            'مالیات ('.$this->taxPercent.'%)' => $this->taxAmount.' تومان',
            'قیمت پیشنهادی' => $this->suggestedPrice.' تومان',
        ];
    }
}
