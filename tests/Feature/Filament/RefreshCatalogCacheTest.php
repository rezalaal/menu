<?php

namespace Tests\Feature\Filament;

use App\Filament\Livewire\RefreshCatalogCache;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use Tests\TestCase;

class RefreshCatalogCacheTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create([
            'email' => 'admin@local.tld',
            'email_verified_at' => now(),
        ]));

        Filament::setCurrentPanel(Filament::getPanel('admin'));
    }

    public function test_the_topbar_button_clears_the_catalog_caches(): void
    {
        Cache::put('products_by_category_v2', ['cached'], 60);
        Cache::put('categories_v2', ['cached'], 60);

        Livewire::test(RefreshCatalogCache::class)
            ->call('refresh');

        $this->assertFalse(Cache::has('products_by_category_v2'));
        $this->assertFalse(Cache::has('categories_v2'));
    }

    public function test_clearing_the_caches_sends_a_notification(): void
    {
        Cache::put('products_by_category_v2', ['cached'], 60);

        Livewire::test(RefreshCatalogCache::class)
            ->call('refresh')
            ->assertNotified('کش کاتالوگ با موفقیت پاک شد');
    }

    public function test_the_topbar_button_is_rendered_on_every_panel_page(): void
    {
        foreach (['/admin', '/admin/raw-materials', '/admin/price-suggestions'] as $url) {
            $response = $this->get($url);

            $response->assertSuccessful();
            $response->assertSee('به‌روزرسانی کش', escape: false);
            $this->assertStringContainsString('wire:click="refresh"', $response->getContent());
        }
    }
}
