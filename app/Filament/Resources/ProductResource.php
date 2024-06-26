<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $label = "محصول";
    protected static ?string $pluralLabel = "محصولات";

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('عنوان محصول')
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->label('توضیحات')
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->label('قیمت به تومان')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\Select::make('category_id')
                    ->label('دسته بندی')
                    ->relationship('category', 'name')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('image')  
                    ->label('تصویر')                  
                    ->conversion('thumb'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('ترتیب')
                    ->integer()
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
                    ->description(fn (Product $record): string => substr($record->description,0,50).'...')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('description')
                //     ->label('توضیحات')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('قیمت به تومان')
                    // ->money('EUR')
                    ->numeric()
                    ->suffix('تومان')
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('ترتیب')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('category')
                ->label('دسته بندی')
                ->relationship('category', 'name')
                ->multiple()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('Up')
                    ->icon('heroicon-o-arrow-up')
                    ->iconButton()
                    ->action(function (Model $record) {
                        if($record->sort_order !=0) {
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
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
}
