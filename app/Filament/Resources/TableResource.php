<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use LaraZeus\Qr\Facades\Qr;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use App\Models\Table as TableModel;
use Illuminate\Support\Facades\Blade;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Popover\Infolists\PopoverEntry;
use App\Filament\Resources\TableResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TableResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class TableResource extends Resource
{
    protected static ?string $label = "میز";
    protected static ?string $pluralLabel = "میزها";

    protected static ?string $model = TableModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('نام')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('image')  
                    ->label('تصویر')                  
                    ->conversion('thumb')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->label('تصویر')
                    ->circular()
                    ->conversion('thumb'),
                Tables\Columns\TextColumn::make('name')
                    ->label('نام')
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
                \LaraZeus\Popover\Tables\PopoverColumn::make('qrcode')
                    // most of filament methods will work
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                 
                    // main options
                    ->trigger('click') // support click and hover
                    ->placement('right') // for more: https://alpinejs.dev/plugins/anchor#positioning
                    ->offset(10) // int px, for more: https://alpinejs.dev/plugins/anchor#offset
                    ->popOverMaxWidth('none')
                    ->icon('heroicon-o-qr-code') // show custom icon
                 
                    // direct HTML content
                    ->content(fn($record) => new HtmlString(Qr::render(data:config('app.url').'/table/'.$record->id)))                                  
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
            'index' => Pages\ListTables::route('/'),
            'create' => Pages\CreateTable::route('/create'),
            'edit' => Pages\EditTable::route('/{record}/edit'),
        ];
    }
}
