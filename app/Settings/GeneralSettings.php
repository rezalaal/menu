<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $init_site_name;
    public string $instagram_id;
    public string $master_mobile;
    public string $about;
    public string $contact;
    public string $work_hours;
    public static function group(): string
    {
        return 'general';
    }
}
