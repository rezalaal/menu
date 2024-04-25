<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.init_site_name', 'Coral Food');
        $this->migrator->add('general.instagram_id', '@coral_foodd');
        $this->migrator->add('general.master_mobile', '09151234568');
    }
};
