<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Services\ProductPriceApprovalService;
use App\Services\ProductPriceCalculator;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action as RepeaterAction;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $label = 'محصول';

    protected static ?string $pluralLabel = 'محصولات';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('عنوان محصول')
                    ->required(),

                Grid::make()
                    ->columns(12)
                    ->schema([
                        MarkdownEditor::make('description')
                            ->label('توضیحات')
                            ->nullable()
                            ->columnSpan(10),
                    ]),

                Grid::make()
                    ->columns(12)
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('قیمت به تومان')
                            ->required()
                            ->numeric()
                            ->prefix('تومان')
                            ->helperText('این قیمت با تایید شما بر اساس قیمت پیشنهادی به‌روزرسانی می‌شود.')
                            ->columnSpan(4),

                        Forms\Components\Select::make('category_id')
                            ->label('دسته بندی')
                            ->relationship('category', 'name')
                            ->required()
                            ->live()
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('portions')
                            ->label('تعداد پرس')
                            ->integer()
                            ->minValue(1)
                            ->default(1)
                            ->live()
                            ->helperText('فرمول مواد اولیه برای چند پرس محصول محاسبه می‌شود.')
                            ->columnSpan(4),
                    ]),

                Forms\Components\Section::make('مواد اولیه و قیمت پیشنهادی')
                    ->description('مواد اولیه شکل‌دهنده این محصول و قیمت پیشنهادی بر اساس فرمول قیمت‌گذاری')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\Repeater::make('rawMaterialRows')
                            ->relationship()
                            ->label('مواد اولیه')
                            ->schema([
                                Forms\Components\Select::make('raw_material_id')
                                    ->label('ماده اولیه')
                                    ->options(fn (): array => RawMaterial::query()
                                        ->where('is_active', true)
                                        ->orderBy('name')
                                        ->pluck('name', 'id')
                                        ->all())
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->distinct()
                                    ->columnSpan(6),

                                Forms\Components\TextInput::make('quantity')
                                    ->label('مقدار مصرفی در هر پرس')
                                    ->numeric()
                                    ->minValue(0.001)
                                    ->step(0.001)
                                    ->live()
                                    ->required()
                                    ->suffix(function (Forms\Get $get): ?string {
                                        $material = self::rawMaterial($get('raw_material_id'));

                                        return $material === null ? null : $material->base_unit->getLabel();
                                    })
                                    ->columnSpan(4),

                                Forms\Components\Placeholder::make('line_cost')
                                    ->label('هزینه این ماده')
                                    ->content(function (Forms\Get $get): string {
                                        $material = self::rawMaterial($get('raw_material_id'));

                                        if ($material === null || blank($get('quantity'))) {
                                            return '—';
                                        }

                                        return number_format(round((float) $get('quantity') * $material->unit_price, 2)).' تومان';
                                    })
                                    ->columnSpan(2),
                            ])
                            ->columns(12)
                            ->defaultItems(0)
                            ->addActionLabel('افزودن ماده اولیه')
                            ->reorderable(false)
                            ->live()
                            ->deleteAction(fn (RepeaterAction $action) => $action->label('حذف ماده اولیه')),

                        Forms\Components\Placeholder::make('suggested_preview')
                            ->label('پیش‌نمایش قیمت پیشنهادی')
                            ->content(function (Forms\Get $get): HtmlString|string {
                                $breakdown = app(ProductPriceCalculator::class)->calculateFromCost(
                                    self::formProduct($get),
                                    self::formMaterialCost($get),
                                );

                                if ($breakdown === null) {
                                    return 'برای مشاهده قیمت پیشنهادی، مواد اولیه این محصول را ثبت کنید.';
                                }

                                $lines = array_map(
                                    fn (string $label, string $value): string => $label.': '.$value,
                                    array_keys($breakdown->toDisplayLines()),
                                    $breakdown->toDisplayLines(),
                                );

                                return new HtmlString(implode('<br>', $lines));
                            })
                            ->columnSpanFull(),

                        Forms\Components\Placeholder::make('saved_suggested_price')
                            ->label('قیمت پیشنهادی ثبت شده')
                            ->content(function (?Product $record): string {
                                if ($record === null || blank($record->suggested_price)) {
                                    return 'قیمت پیشنهادی ثبت نشده است';
                                }

                                $calculatedAt = $record->suggested_price_calculated_at;

                                return number_format((int) $record->suggested_price).' تومان'
                                    .($calculatedAt === null ? '' : ' (محاسبه شده '.$calculatedAt->diffForHumans().')');
                            })
                            ->helperText('این مقدار با تایید شما در فیلد قیمت محصول ثبت می‌شود.')
                            ->columnSpan(9),

                        Forms\Components\Actions::make([
                            RepeaterAction::make('recalculate_suggested_price')
                                ->label('محاسبه قیمت پیشنهادی')
                                ->icon('heroicon-m-calculator')
                                ->color('gray')
                                ->visible(fn (?Product $record): bool => $record?->exists === true)
                                ->action(function (?Product $record, Forms\Get $get): void {
                                    if ($record === null) {
                                        return;
                                    }

                                    $breakdown = app(ProductPriceCalculator::class)->calculateFromCost(
                                        self::formProduct($get),
                                        self::formMaterialCost($get),
                                    );

                                    if ($breakdown === null) {
                                        Notification::make()
                                            ->warning()
                                            ->title('ابتدا مواد اولیه این محصول را ثبت کنید')
                                            ->send();

                                        return;
                                    }

                                    app(ProductPriceCalculator::class)->persist($record, $breakdown);

                                    Notification::make()
                                        ->success()
                                        ->title('قیمت پیشنهادی: '.number_format($breakdown->suggestedPrice).' تومان')
                                        ->send();
                                }),
                        ])
                            ->columnSpan(3),
                    ]),

                Grid::make()
                    ->columns(12)
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('image')
                            ->label('تصویر')
                            ->conversion('thumb')
                            ->columnSpan(6),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('ترتیب')
                            ->integer()
                            ->columnSpan(6),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Product::orderBy('sort_order'))
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->circular()
                    ->label('تصویر')
                    ->conversion('thumb'),
                Tables\Columns\TextColumn::make('name')
                    ->label('عنوان محصول')
                    ->description(fn (Product $record): string => substr($record->description, 0, 50).'...')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('قیمت به تومان')
                    ->numeric()
                    ->suffix('تومان')
                    ->sortable(),
                Tables\Columns\TextColumn::make('suggested_price')
                    ->label('قیمت پیشنهادی')
                    ->numeric()
                    ->suffix(' تومان')
                    ->description(fn (Product $record): ?string => $record->suggested_price_calculated_at?->diffForHumans())
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('price_approved_at')
                    ->label('زمان تایید قیمت')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('pending_price_suggestions_count')
                    ->label('پیشنهاد تایید نشده')
                    ->counts('pendingPriceSuggestions')
                    ->badge()
                    ->color(fn (int $state): string => $state > 0 ? 'warning' : 'gray')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('دسته بندی')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('تاریخ ویرایش')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('دسته بندی')
                    ->relationship('category', 'name')
                    ->multiple(),
                SelectFilter::make('suggestion_status')
                    ->label('وضعیت قیمت پیشنهادی')
                    ->options([
                        'pending' => 'در انتظار تایید',
                        'approved' => 'تایید شده',
                        'none' => 'بدون پیشنهاد',
                    ])
                    ->query(fn (Builder $query, array $data): Builder => match ($data['value'] ?? null) {
                        'pending' => $query->whereHas('pendingPriceSuggestions'),
                        'approved' => $query->whereRelation('priceSuggestions', 'status', 'approved'),
                        'none' => $query->whereDoesntHave('priceSuggestions'),
                        default => $query,
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                self::recalculateAction(),
                self::approveAction(),
                Action::make('Up')
                    ->icon('heroicon-o-arrow-up')
                    ->iconButton()
                    ->action(function (Model $record) {
                        if ($record->sort_order != 0) {
                            $record->sort_order -= 1;
                            $record->save();
                        }
                    }),
                Action::make('Down')
                    ->icon('heroicon-o-arrow-down')
                    ->iconButton()
                    ->action(function (Model $record) {
                        $record->sort_order += 1;
                        $record->save();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    self::approveBulkAction(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    private static function rawMaterial(mixed $id): ?RawMaterial
    {
        if (blank($id)) {
            return null;
        }

        return RawMaterial::query()->find($id);
    }

    /**
     * Total cost of the raw materials filled in the product form.
     */
    private static function formMaterialCost(Forms\Get $get): float
    {
        $rows = collect($get('rawMaterialRows'))
            ->filter(fn ($row): bool => filled($row['raw_material_id'] ?? null));

        $cost = $rows->sum(function ($row): float {
            $material = self::rawMaterial($row['raw_material_id'] ?? null);

            if ($material === null || blank($row['quantity'] ?? null)) {
                return 0.0;
            }

            return (float) $row['quantity'] * $material->unit_price;
        });

        return round((float) $cost, 2);
    }

    /**
     * A transient product holding the category and portions chosen in the
     * form, used to preview the suggested price of an unsaved product.
     */
    private static function formProduct(Forms\Get $get): Product
    {
        $category = Category::query()->find($get('category_id'));

        $product = new Product([
            'portions' => (int) $get('portions'),
        ]);

        $product->setRelation('category', $category);

        return $product;
    }

    private static function recalculateAction(): Action
    {
        return Action::make('recalculate_suggested_price')
            ->label('محاسبه قیمت پیشنهادی')
            ->icon('heroicon-m-calculator')
            ->color('gray')
            ->action(fn (Product $record) => self::recalculatePrice($record->refresh()));
    }

    private static function approveAction(): Action
    {
        return Action::make('approve_suggested_price')
            ->label('تایید قیمت پیشنهادی')
            ->icon('heroicon-o-check-badge')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('تایید قیمت پیشنهادی')
            ->modalDescription(fn (Product $record): string => sprintf(
                'قیمت محصول «%s» از %s تومان به %s تومان تغییر می‌کند.',
                $record->name,
                number_format((int) $record->price),
                number_format((int) $record->suggested_price),
            ))
            ->modalSubmitActionLabel('تایید و اعمال روی قیمت')
            ->visible(fn (Product $record): bool => $record->pendingPriceSuggestions()->exists())
            ->action(fn (Product $record) => self::approvePrice($record));
    }

    private static function approveBulkAction(): BulkAction
    {
        return BulkAction::make('approve_suggested_price')
            ->label('تایید قیمت پیشنهادی')
            ->icon('heroicon-o-check-badge')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('تایید قیمت پیشنهادی')
            ->modalDescription('قیمت همه محصولات انتخاب شده، بر اساس قیمت پیشنهادی تایید شده آن‌ها به‌روزرسانی می‌شود.')
            ->action(function (Collection $records): void {
                $products = Product::query()->whereKey($records->modelKeys())->get();

                $updated = app(ProductPriceApprovalService::class)->approveMany($products);

                Notification::make()
                    ->success()
                    ->title('قیمت '.$updated.' محصول به‌روزرسانی شد')
                    ->send();
            });
    }

    private static function recalculatePrice(Product $record): void
    {
        $breakdown = app(ProductPriceCalculator::class)->recalculate($record);

        if ($breakdown === null) {
            Notification::make()
                ->warning()
                ->title('ابتدا مواد اولیه این محصول را ثبت کنید')
                ->send();

            return;
        }

        Notification::make()
            ->success()
            ->title('قیمت پیشنهادی: '.number_format($breakdown->suggestedPrice).' تومان')
            ->send();
    }

    private static function approvePrice(Product $record): void
    {
        $approved = app(ProductPriceApprovalService::class)->approve($record);

        if ($approved === null) {
            Notification::make()
                ->warning()
                ->title('پیشنهاد قیمتی برای تایید وجود ندارد')
                ->body('ابتدا قیمت پیشنهادی این محصول را محاسبه کنید.')
                ->send();

            return;
        }

        Notification::make()
            ->success()
            ->title('قیمت محصول '.$record->refresh()->name.' به '.number_format((int) $record->price).' تومان به‌روزرسانی شد')
            ->send();
    }
}
