<?php

namespace App\Filament\Resources\UserCustomerResource\RelationManagers;

use App\Models\Order;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class OrderRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';
    protected static ?string $label = 'سفارش';
    protected static ?string $pluralLabel = 'سفارش‌ها';
    protected static ?string $title = 'سفارش‌های مشتری';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('شماره سفارش'),
                Tables\Columns\TextColumn::make('total')->label('جمع کل')->money('IRR'),
                Tables\Columns\TextColumn::make('status')->label('وضعیت'),
                Tables\Columns\TextColumn::make('created_at')->label('تاریخ ثبت')->formatStateUsing(
                    fn ($state) => \Hekmatinasser\Verta\Verta::instance($state)->format('Y/m/d H:i')
                ),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordUrl(null); // لینک به سفارش را غیرفعال می‌کند (اختیاری)
    }
}
