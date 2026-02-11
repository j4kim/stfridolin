<?php

namespace App\Filament\Resources\Guests\Tables;

use App\Filament\Tools\ColumnTools;
use App\Models\Guest;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GuestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('key')
                    ->searchable(),
                TextColumn::make('tokens')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('points')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payments_sum_amount')
                    ->label("Spent")
                    ->sum('payments', 'amount')
                    ->money('CHF')
                    ->sortable()
                    ->toggleable()
                    ->url(fn(int $state, Guest $guest): ?string => $state ? $guest->paymentsUrl() : null),
                TextColumn::make('movements_count')
                    ->label("Movements")
                    ->counts('movements')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->url(fn(int $state, Guest $guest): ?string => $state ? $guest->movementsUrl() : null),
                IconColumn::make('registration_movements_count')
                    ->boolean()
                    ->label("Registered")
                    ->counts('registrationMovements')
                    ->sortable()
                    ->toggleable(),
            ])
            ->persistSortInSession()
            ->filters([
                //
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
