<?php

namespace App\Filament\Resources;

use App\Enums\MaterialUnit;
use App\Filament\Resources\RawMaterialResource\Pages;
use App\Filament\Resources\RawMaterialResource\RelationManagers\ProductRawMaterialsRelationManager;
use App\Models\RawMaterial;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Exceptions\Halt;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class RawMaterialResource extends Resource
{
    protected static ?string $model = RawMaterial::class;

    protected static ?string $label = 'ماده اولیه';

    protected static ?string $pluralLabel = 'مواد اولیه';

    protected static ?string $navigationGroup = 'قیمت‌گذاری';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->columns(12)
                    ->schema([
                        TextInput::make('name')
                            ->label('نام ماده اولیه')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpan(6),

                        Toggle::make('is_active')
                            ->label('فعال')
                            ->default(true)
                            ->columnSpan(3),

                        Forms\Components\Select::make('base_unit')
                            ->label('واحد پایه')
                            ->options(MaterialUnit::class)
                            ->native(false)
                            ->required()
                            ->columnSpan(4),

                        TextInput::make('purchase_quantity')
                            ->label('مقدار خرید')
                            ->numeric()
                            ->minValue(0.001)
                            ->step(0.001)
                            ->default(1)
                            ->live()
                            ->required()
                            ->helperText('مقدار خرید: مثلاً ۱ برای یک شیشه یا ۱۰۰۰ برای یک کیلوگرم')
                            ->columnSpan(4),

                        TextInput::make('purchase_price')
                            ->label('قیمت خرید')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('تومان')
                            ->live()
                            ->required()
                            ->helperText('قیمت یک عدد / یک بسته ماده اولیه')
                            ->columnSpan(4),

                        Forms\Components\Placeholder::make('unit_price')
                            ->label('قیمت هر واحد پایه')
                            ->content(function (Forms\Get $get): string {
                                $quantity = (float) $get('purchase_quantity');

                                if ($quantity <= 0) {
                                    return 'مقدار خرید را وارد کنید';
                                }

                                $price = (float) $get('purchase_price');

                                return number_format(round($price / $quantity, 2)).' تومان';
                            })
                            ->columnSpan(12),

                        Textarea::make('notes')
                            ->label('توضیحات')
                            ->columnSpan(12),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('نام ماده اولیه')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_unit')
                    ->label('واحد پایه')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchase_price')
                    ->label('قیمت خرید')
                    ->numeric()
                    ->suffix(' تومان')
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchase_quantity')
                    ->label('مقدار خرید')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_price')
                    ->label('قیمت هر واحد')
                    ->formatStateUsing(fn (float $state): string => number_format($state).' تومان'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('وضعیت')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخرین ویرایش')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('base_unit')
                    ->label('واحد پایه')
                    ->options(MaterialUnit::class),
                TernaryFilter::make('is_active')
                    ->label('فعال'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (RawMaterial $record): void {
                        if (! $record->isUsedInProducts()) {
                            return;
                        }

                        Notification::make()
                            ->title('حذف ماده اولیه امکان‌پذیر نیست')
                            ->body('این ماده اولیه در فرمول یک یا چند محصول استفاده شده است. کافی است آن را غیرفعال کنید.')
                            ->danger()
                            ->send();

                        throw new Halt;
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records): void {
                            $names = $records
                                ->filter(fn (RawMaterial $record): bool => $record->isUsedInProducts())
                                ->pluck('name')
                                ->implode('، ');

                            if ($names === '') {
                                return;
                            }

                            Notification::make()
                                ->title('حذف برخی مواد اولیه امکان‌پذیر نیست')
                                ->body('مواد اولیه '.$names.' در فرمول محصولات استفاده شده‌اند. کافی است آن‌ها را غیرفعال کنید.')
                                ->danger()
                                ->send();

                            throw new Halt;
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProductRawMaterialsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRawMaterials::route('/'),
            'create' => Pages\CreateRawMaterial::route('/create'),
            'edit' => Pages\EditRawMaterial::route('/{record}/edit'),
        ];
    }
}
