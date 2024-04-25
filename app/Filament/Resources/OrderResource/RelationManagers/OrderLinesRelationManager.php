<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class OrderLinesRelationManager extends RelationManager
{
    protected static string $relationship = 'orderLines';
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->label('نام محصول')
                    ->required(),
                Forms\Components\TextInput::make('qty')
                    ->required()
                    ->label('تعداد')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product.name')
            ->columns([
                SpatieMediaLibraryImageColumn::make('product.image')
                    ->circular()
                    ->label('تصویر')
                    ->conversion('thumb'),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('نام محصول')
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->label('تعداد'),
                Tables\Columns\TextColumn::make('price')
                    ->suffix('ریال ')
                    ->numeric()
                    ->label('مبلغ'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
