<?php

namespace App\Providers\Filament;

use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Notifications\Notification;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Lime,
            ])
            ->font('IRANSansX')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->plugin(FilamentSpatieLaravelBackupPlugin::make())
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                fn () => new HtmlString('
                    <style>
                        @font-face {
                            font-family: "IRANSansX";
                            src: url("'.asset('fonts/woff2/IRANSansX-Regular.woff2').'") format("woff2");
                            font-weight: 400;
                            font-style: normal;
                            font-display: swap;
                        }
                        @font-face {
                            font-family: "IRANSansX";
                            src: url("'.asset('fonts/woff2/IRANSansX-Medium.woff2').'") format("woff2");
                            font-weight: 500;
                            font-style: normal;
                            font-display: swap;
                        }
                        @font-face {
                            font-family: "IRANSansX";
                            src: url("'.asset('fonts/woff2/IRANSansX-Bold.woff2').'") format("woff2");
                            font-weight: 700;
                            font-style: normal;
                            font-display: swap;
                        }
                        @font-face {
                            font-family: "IRANSansX";
                            src: url("'.asset('fonts/woff2/IRANSansX-ExtraBold.woff2').'") format("woff2");
                            font-weight: 800;
                            font-style: normal;
                            font-display: swap;
                        }
                        @font-face {
                            font-family: "IRANSansX";
                            src: url("'.asset('fonts/woff2/IRANSansX-Light.woff2').'") format("woff2");
                            font-weight: 300;
                            font-style: normal;
                            font-display: swap;
                        }
                        @font-face {
                            font-family: "IRANSansX";
                            src: url("'.asset('fonts/woff2/IRANSansX-Thin.woff2').'") format("woff2");
                            font-weight: 100;
                            font-style: normal;
                            font-display: swap;
                        }
                    </style>
                ')
            )
            ->renderHook(
                PanelsRenderHook::TOPBAR_END,
                fn () => Action::make('refreshCatalogCache')
                    ->label('به‌روزرسانی کش')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('به‌روزرسانی کش کاتالوگ')
                    ->modalDescription('کش محصولات و دسته‌بندی‌ها پاک می‌شود و در اولین بازدید بعدی سایت با اطلاعات تازه از دیتابیس بازسازی می‌شود.')
                    ->modalSubmitActionLabel('پاک‌سازی کش')
                    ->action(function () {
                        Cache::forget('products_by_category_v2');
                        Cache::forget('categories_v2');

                        Notification::make()
                            ->success()
                            ->title('کش کاتالوگ با موفقیت پاک شد')
                            ->send();
                    })
                    ->render(),
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
