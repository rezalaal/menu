<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use App\Settings\GeneralSettings;
use Filament\Forms\Components\TextInput;

class ManageGeneralSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;

    protected static ?string $navigationLabel = "تنظیمات";

    protected static ?string $title = "تنظیمات عمومی";
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('init_site_name')
                    ->label('عنوان')
                    ->required(),
                TextInput::make('instagram_id')
                    ->label('آیدی اینستاگرام')
                    ->suffix('@')
                    ->required(),
                TextInput::make('master_mobile')
                    ->label('تلفن همراه مدیر')
                    ->required(),
            ]);
    }
}
