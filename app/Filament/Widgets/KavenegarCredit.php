<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class KavenegarCredit extends BaseWidget
{
    protected function getStats(): array
    {
        $apiKey = Config::get('services.kavenegar.api_key');

        $response = Http::get("https://api.kavenegar.com/v1/{$apiKey}/account/info.json");

        if ($response->successful() && $response['return']['status'] === 200) {
            $remainCredit = $response['entries']['remaincredit'];

            return [
                Stat::make('اعتبار باقیمانده پیامک', number_format($remainCredit) . ' ریال'),
            ];
        }

        return [
            Stat::make('اعتبار باقی مانده پیامک', 'خطا در دریافت اطلاعات')
                ->description('بررسی تنظیمات Kavenegar')
                ->color('danger'),
        ];
    }
}

