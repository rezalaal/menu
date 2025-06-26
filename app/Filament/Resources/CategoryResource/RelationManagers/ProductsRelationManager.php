<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Resources\RelationManagers\RelationManager;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $title = 'محصولات مرتبط';
    protected static ?string $label = 'محصول';
    protected static ?string $pluralLabel = 'محصولات';

    // ✅ فرم ویرایش/ایجاد
    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('عنوان محصول')
                ->required(),
            Forms\Components\TextInput::make('price')
                ->label('قیمت')
                ->numeric()
                ->required()
                ->suffix('تومان'),
        ]);
    }

    // ✅ جدول نمایش
    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('شناسه')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('نام محصول')->searchable(),
                Tables\Columns\TextColumn::make('price')->label('قیمت')->numeric()->suffix(' تومان'),
                Tables\Columns\TextColumn::make('created_at')->label('تاریخ ایجاد')->dateTime(),
            ])
            ->filters([])
            ->headerActions([]) // اگر نمی‌خواهی محصول جدید از اینجا اضافه شود
            ->actions([
                Tables\Actions\EditAction::make(), // ✅ دکمه ویرایش فعال
            ])
            ->bulkActions([]);
    }
}
