<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $init_site_name;
    public string $instagram_id;
    public string $master_mobile;

    public static function group(): string
    {
        return 'general';
    }
}