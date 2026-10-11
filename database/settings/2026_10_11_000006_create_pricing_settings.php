<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('pricing.waste_percent', 3.0);
        $this->migrator->add('pricing.overhead_percent', 15.0);
        $this->migrator->add('pricing.profit_percent', 40.0);
        $this->migrator->add('pricing.tax_percent', 10.0);
        $this->migrator->add('pricing.rounding_step', 1000);
    }
};
