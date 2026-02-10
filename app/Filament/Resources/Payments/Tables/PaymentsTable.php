<?php

namespace App\Filament\Resources\Payments\Tables;

use App\Enums\PaymentPurpose;
use App\Enums\PaymentStatus;
use App\Filament\Tools\ColumnTools;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),
                TextColumn::make('guest.name')
                    ->searchable(),
                TextColumn::make('stripe_status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('purpose')
                    ->badge()
                    ->searchable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('guest')
                    ->relationship('guest', 'name'),
                SelectFilter::make('stripe_status')
                    ->default(PaymentStatus::succeeded)
                    ->options(PaymentStatus::class),
                SelectFilter::make('purpose')
                    ->options(PaymentPurpose::class),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
