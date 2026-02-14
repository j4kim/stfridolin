<?php

namespace App\Filament\Resources\Guests\Tables;

use App\Filament\Tools\ColumnTools;
use App\Models\Guest;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                TextColumn::make('succeeded_payments_sum_amount')
                    ->label("Spent")
                    ->sum('succeededPayments', 'amount')
                    ->money('CHF')
                    ->sortable()
                    ->toggleable()
                    ->url(fn(int $state, Guest $guest): ?string => $state ? $guest->paymentsUrl() : null)
                    ->summarize([Sum::make(), Average::make()]),
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
                TernaryFilter::make('registered')
                    ->queries(
                        true: fn(Builder $query) => $query->has('registrationMovements'),
                        false: fn(Builder $query) => $query->doesntHave('registrationMovements'),
                        blank: fn(Builder $query) => $query,
                    ),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->summaries(
                pageCondition: false
            );
    }
}
