<?php

namespace App\Filament\Resources;

use App\Enums\PriceSuggestionStatus;
use App\Filament\Resources\PriceSuggestionResource\Pages;
use App\Models\PriceSuggestion;
use App\Services\ProductPriceApprovalService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PriceSuggestionResource extends Resource
{
    protected static ?string $model = PriceSuggestion::class;

    protected static ?string $label = 'پیشنهاد قیمت';

    protected static ?string $pluralLabel = 'تاریخچه قیمت‌گذاری';

    protected static ?string $navigationGroup = 'قیمت‌گذاری';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static bool $canCreate = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات محاسبه قیمت')
                    ->columns(12)
                    ->schema([
                        Forms\Components\Placeholder::make('product_name')
                            ->label('محصول')
                            ->content(fn (PriceSuggestion $record): string => $record->product->name ?? '—')
                            ->columnSpan(6),

                        Forms\Components\Placeholder::make('status')
                            ->label('وضعیت')
                            ->content(fn (PriceSuggestion $record): string => $record->status->getLabel())
                            ->columnSpan(6),

                        Forms\Components\Placeholder::make('material_cost')
                            ->label('هزینه مواد اولیه')
                            ->content(fn (PriceSuggestion $record): string => number_format((float) $record->material_cost).' تومان')
                            ->columnSpan(6),

                        Forms\Components\Placeholder::make('suggested_price')
                            ->label('قیمت پیشنهادی')
                            ->content(fn (PriceSuggestion $record): string => number_format((float) $record->suggested_price).' تومان')
                            ->columnSpan(6),

                        Forms\Components\Placeholder::make('waste_percent')
                            ->label('درصد ریخت و پاش')
                            ->content(fn (PriceSuggestion $record): string => $record->waste_percent.'%')
                            ->columnSpan(3),

                        Forms\Components\Placeholder::make('overhead_percent')
                            ->label('درصد سربار و دستمزد')
                            ->content(fn (PriceSuggestion $record): string => $record->overhead_percent.'%')
                            ->columnSpan(3),

                        Forms\Components\Placeholder::make('profit_percent')
                            ->label('درصد حاشیه سود')
                            ->content(fn (PriceSuggestion $record): string => $record->profit_percent.'%')
                            ->columnSpan(3),

                        Forms\Components\Placeholder::make('tax_percent')
                            ->label('درصد مالیات')
                            ->content(fn (PriceSuggestion $record): string => $record->tax_percent.'%')
                            ->columnSpan(3),

                        Forms\Components\Placeholder::make('reviewer')
                            ->label('بررسی‌کننده')
                            ->content(fn (PriceSuggestion $record): string => optional($record->reviewer)->name ?? '—')
                            ->columnSpan(6),

                        Forms\Components\Placeholder::make('reviewed_at')
                            ->label('زمان بررسی')
                            ->content(fn (PriceSuggestion $record): string => $record->reviewed_at?->diffForHumans() ?? '—')
                            ->columnSpan(6),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with('product', 'reviewer'))
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('محصول')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('material_cost')
                    ->label('هزینه مواد')
                    ->numeric()
                    ->suffix(' تومان')
                    ->sortable(),
                Tables\Columns\TextColumn::make('waste_percent')
                    ->label('ریخت و پاش')
                    ->numeric()
                    ->suffix('%')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('overhead_percent')
                    ->label('سربار')
                    ->numeric()
                    ->suffix('%')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('profit_percent')
                    ->label('سود')
                    ->numeric()
                    ->suffix('%')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('tax_percent')
                    ->label('مالیات')
                    ->numeric()
                    ->suffix('%')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('suggested_price')
                    ->label('قیمت پیشنهادی')
                    ->numeric()
                    ->suffix(' تومان')
                    ->weight('bold')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewer.name')
                    ->label('بررسی‌کننده')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('زمان محاسبه')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options(PriceSuggestionStatus::class),
                SelectFilter::make('product')
                    ->label('محصول')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->multiple(),
                SelectFilter::make('product_category')
                    ->label('دسته‌بندی محصول')
                    ->relationship('product.category', 'name')
                    ->searchable()
                    ->multiple(),
            ])
            ->actions([
                self::approveAction(),
                Tables\Actions\Action::make('reject')
                    ->label('رد پیشنهاد')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (PriceSuggestion $record): bool => $record->status === PriceSuggestionStatus::PENDING)
                    ->action(function (PriceSuggestion $record): void {
                        app(ProductPriceApprovalService::class)->reject($record);

                        Notification::make()
                            ->success()
                            ->title('پیشنهاد قیمت '.$record->product->name.' رد شد')
                            ->send();
                    }),
                Tables\Actions\EditAction::make()
                    ->label('جزئیات'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPriceSuggestions::route('/'),
            'edit' => Pages\EditPriceSuggestion::route('/{record}/edit'),
        ];
    }

    private static function approveAction(): Tables\Actions\Action
    {
        return Tables\Actions\Action::make('approve')
            ->label('تایید و اعمال روی قیمت')
            ->icon('heroicon-o-check-badge')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('تایید قیمت پیشنهادی')
            ->modalDescription(fn (PriceSuggestion $record): string => sprintf(
                'قیمت محصول «%s» از %s تومان به %s تومان تغییر می‌کند.',
                $record->product->name,
                number_format((int) $record->product->price),
                number_format((float) $record->suggested_price),
            ))
            ->modalSubmitActionLabel('تایید و اعمال')
            ->visible(fn (PriceSuggestion $record): bool => $record->status === PriceSuggestionStatus::PENDING)
            ->action(function (PriceSuggestion $record): void {
                $approved = app(ProductPriceApprovalService::class)->approve($record->product);

                if ($approved === null) {
                    Notification::make()
                        ->warning()
                        ->title('پیشنهاد قیمتی برای این محصول یافت نشد')
                        ->send();

                    return;
                }

                Notification::make()
                    ->success()
                    ->title('قیمت محصول '.$record->product->name.' به‌روزرسانی شد')
                    ->send();
            });
    }
}
