<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class GeneralSettingsControllerTest extends TestCase
{
    public function test_returns_general_settings(): void
    {
        $response = $this->getJson('/api/settings/general');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'site_name',
                'instagram_id',
                'master_mobile',
                'about',
                'contact',
                'work_hours',
            ]);
    }

    public function test_returns_default_values_when_no_settings_configured(): void
    {
        $response = $this->getJson('/api/settings/general');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'site_name',
            'instagram_id',
            'master_mobile',
            'about',
            'contact',
            'work_hours',
        ]);
    }
}
