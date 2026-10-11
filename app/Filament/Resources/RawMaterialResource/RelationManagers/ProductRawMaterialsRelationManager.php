<?php

namespace App\Filament\Resources\RawMaterialResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ProductRawMaterialsRelationManager extends RelationManager
{
    protected static string $relationship = 'productRawMaterials';

    protected static ?string $title = 'محصولات مصرف‌کننده';

    protected static ?string $label = 'محصول';

    protected static ?string $pluralLabel = 'محصولات';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with('rawMaterial', 'product'))
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('محصول')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('مقدار مصرفی در هر پرس')
                    ->numeric(),
                Tables\Columns\TextColumn::make('line_cost')
                    ->label('هزینه این ماده')
                    ->formatStateUsing(fn (float $state): string => number_format($state).' تومان'),
                Tables\Columns\TextColumn::make('product.category.name')
                    ->label('دسته‌بندی')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->headerActions([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\TextInput::make('quantity')
                            ->label('مقدار مصرفی در هر پرس (بر همان واحد پایه)')
                            ->numeric()
                            ->minValue(0.001)
                            ->step(0.001)
                            ->required(),
                    ]),
            ])
            ->bulkActions([]);
    }
}
