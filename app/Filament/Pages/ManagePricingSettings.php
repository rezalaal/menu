<?php

namespace App\Filament\Pages;

use App\Settings\PricingSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManagePricingSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static string $settings = PricingSettings::class;

    protected static ?string $navigationGroup = 'تنظیمات';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'فرمول قیمت‌گذاری';

    protected static ?string $title = 'فرمول قیمت‌گذاری';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('درصدهای پیش‌فرض')
                    ->description('این درصدها روی همه محصولات اعمال می‌شود، مگر اینکه در دسته‌بندی محصول درصد اختصاصی تعیین شده باشد.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('waste_percent')
                            ->label('درصد ریخت و پاش')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->required(),

                        TextInput::make('overhead_percent')
                            ->label('درصد سربار و دستمزد')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->required(),

                        TextInput::make('profit_percent')
                            ->label('درصد حاشیه سود')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->required(),

                        TextInput::make('tax_percent')
                            ->label('درصد مالیات')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->required(),
                    ]),

                Section::make('گرد کردن قیمت پیشنهادی')
                    ->schema([
                        TextInput::make('rounding_step')
                            ->label('گام گرد کردن (تومان)')
                            ->integer()
                            ->minValue(0)
                            ->default(1000)
                            ->helperText('قیمت پیشنهادی به مضربی از این عدد گرد می‌شود. برای بدون گرد کردن مقدار ۰ را وارد کنید.')
                            ->required(),
                    ]),
            ]);
    }
}
