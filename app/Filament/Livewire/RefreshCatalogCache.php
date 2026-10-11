<?php

namespace App\Filament\Livewire;

use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class RefreshCatalogCache extends Component
{
    public function refresh(): void
    {
        Cache::forget('products_by_category_v2');
        Cache::forget('categories_v2');

        Notification::make()
            ->success()
            ->title('کش کاتالوگ با موفقیت پاک شد')
            ->body('در اولین بازدید بعدی سایت، اطلاعات از دیتابیس خوانده می‌شود.')
            ->send();
    }

    public function render(): View
    {
        return view('filament.livewire.refresh-catalog-cache');
    }
}
