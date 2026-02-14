<?php

namespace App\Filament\Resources\Payments\Tables;

use App\Enums\PaymentPurpose;
use App\Enums\PaymentStatus;
use App\Filament\Resources\Guests\RelationManagers\PaymentsRelationManager;
use App\Filament\Tools\ColumnTools;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
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
                ColumnTools::guestLinkColumn()
                    ->hiddenOn(PaymentsRelationManager::class),
                TextColumn::make('stripe_status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('purpose')
                    ->badge()
                    ->searchable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable()
                    ->summarize([Sum::make(), Average::make()]),
                TextColumn::make('stripe_data.description')
                    ->label("Description")
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('stripe_data.metadata.remarks')
                    ->label("Remarks")
                    ->sortable()
                    ->toggleable(),
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
            ]);
    }
}
