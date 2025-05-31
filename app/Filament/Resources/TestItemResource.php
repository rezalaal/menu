<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestItemResource\Pages;
use App\Filament\Resources\TestItemResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestItemResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $label = "category";
    protected static ?string $pluralLabel = "categories";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('عنوان دسته بندی')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('image')  
                    // ->beforeStateDehydrated(function() {
                    //     info("image upload dehydrated");
                    // })
                    ->label('تصویر')                  
                    ->conversion('thumb'),
                    // ->afterStateUpdated(function ($state) {
                    //     info('Uploaded file info:', ['state' => $state]);
                    // }),
                Forms\Components\TextInput::make('sort_order')
                    ->label('ترتیب')
                    ->integer()
                    ->rules(['nullable', 'numeric','min:0'])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->circular()
                    ->label('تصویر'),
                    // ->conversion('thumb'),
                Tables\Columns\TextColumn::make('name')
                    ->label('عنوان دسته بندی')
                    ->searchable(),                
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTestItems::route('/'),
            'create' => Pages\CreateTestItem::route('/create'),
            'edit' => Pages\EditTestItem::route('/{record}/edit'),
        ];
    }
}
