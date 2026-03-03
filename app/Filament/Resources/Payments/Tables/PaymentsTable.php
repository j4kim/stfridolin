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
                TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('purpose')
                    ->badge()
                    ->searchable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable()
                    ->summarize([Sum::make(), Average::make()]),
                ColumnTools::tooltipped('description')
                    ->label("Description")
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                ColumnTools::tooltipped('meta.remarks')
                    ->label("Remarques")
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('method')
                    ->badge()
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('guest')
                    ->relationship('guest', 'name'),
                SelectFilter::make('status')
                    ->options(PaymentStatus::class),
                SelectFilter::make('purpose')
                    ->options(PaymentPurpose::class),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
