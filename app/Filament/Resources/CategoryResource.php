<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\CategoryResource\RelationManagers;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $label = "دسته بندی";
    protected static ?string $pluralLabel = "دسته بندی";

    public static function form(Form $form): Form
    {
        info("Edit category form");
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('عنوان دسته بندی')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('image')  
                    ->beforeStateDehydrated(function() {
                        info("image upload dehydrated");
                    })
                    ->label('تصویر')                  
                    // ->conversion('thumb')
                    ->afterStateUpdated(function ($state) {
                        info('Uploaded file info:', ['state' => $state]);
                    }),
                Forms\Components\TextInput::make('sort_order')
                    ->label('ترتیب')
                    ->integer()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Category::orderBy('sort_order'))
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->circular()
                    ->label('تصویر'),
                    // ->conversion('thumb'),
                Tables\Columns\TextColumn::make('name')
                    ->label('عنوان دسته بندی')
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('sort_order')
                    ->rules(['required', 'numeric','min:0'])
                    ->label('ترتیب'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
