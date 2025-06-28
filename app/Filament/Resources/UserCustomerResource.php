<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserCustomerResource\Pages;
use App\Filament\Resources\UserCustomerResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Hekmatinasser\Verta\Verta;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;


class UserCustomerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'مشتری‌ها';
    protected static ?string $pluralLabel = 'مشتری‌ها';
    protected static ?string $label = 'مشتری';


    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')
                ->label('نام مشتری')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('username')->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                ->label('تاریخ ثبت')
                ->formatStateUsing(function ($state) {
                    if (!$state) {
                        return null;
                    }
                    $verta = Verta::instance($state);
                    return $verta->format('Y/m/d H:i');
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrderRelationManager::class,
        ];
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(function ($query) {
                $query->whereNull('email')
                    ->orWhere('email', 'not like', '%@local.tld');
            })
            ->orderByDesc('created_at');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserCustomers::route('/'),
            // 'create' => Pages\CreateUserCustomer::route('/create'),
            'edit' => Pages\EditUserCustomer::route('/{record}/edit'),
        ];
    }
}
