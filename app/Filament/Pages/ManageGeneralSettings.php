<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use App\Settings\GeneralSettings;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Tabs;

class ManageGeneralSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;

    protected static ?string $navigationGroup = 'تنظیمات';

    protected static ?string $navigationLabel = "اطلاعات پایه";

    protected static ?string $title = "اطلاعات پایه";

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('تنظیمات')
                    ->columnSpanFull()
                    ->extraAttributes(['class' => 'justify-end'])
                    ->tabs([
                        Tabs\Tab::make('اطلاعات پایه')
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
                            ]),
                        Tabs\Tab::make('درباره ما')
                            ->schema([
                                MarkdownEditor::make('about')
                                    ->label('درباره ما')
                                    ->helperText('متن را می‌توانید با فرمت Markdown وارد کنید.')
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('اطلاعات تماس')
                            ->schema([
                                MarkdownEditor::make('contact')
                                    ->label('اطلاعات تماس')
                                    ->helperText('شماره تماس، آدرس، ایمیل و ...')
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('ساعات کاری')
                            ->schema([
                                MarkdownEditor::make('work_hours')
                                    ->label('ساعات کاری')
                                    ->columnSpanFull(),
                            ]),
                    ])
            ]);
    }

}
