<?php

namespace Tests\Feature\Filament;

use App\Filament\Pages\ManageGeneralSettings;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use Tests\TestCase;

class ManageGeneralSettingsTest extends TestCase
{
    public function test_saving_settings_clears_general_settings_cache(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@local.tld',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);
        Filament::setCurrentPanel(Filament::getPanel('admin'));

        Cache::put('general_settings', ['cached'], 60);

        Livewire::test(ManageGeneralSettings::class)
            ->set('data', [
                'init_site_name' => 'Coral',
                'instagram_id' => 'coral',
                'master_mobile' => '09120000000',
                'about' => 'about',
                'contact' => 'contact',
                'work_hours' => 'hours',
            ])
            ->call('save');

        $this->assertFalse(Cache::has('general_settings'));
    }
}
