<?php

namespace App\Filament\Resources\Guests\Tables;

use App\Filament\Tools\ColumnTools;
use App\Models\Guest;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
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
                    ->sum('succeededPayments', 'amount')
                    ->money('CHF')
                    ->sortable()
                    ->toggleable()
                    ->url(fn(int $state, Guest $guest) => ColumnTools::paymentsUrl('guest', $guest->id))
                    ->summarize([Sum::make(), Average::make()])
                    ->visibleFrom('sm'),
                TextColumn::make('movements_count')
                    ->counts('movements')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->url(fn(int $state, Guest $guest) => ColumnTools::movementsUrl('guest', $guest->id))
                    ->visibleFrom('sm'),
                IconColumn::make('registration_movements_count')
                    ->boolean()
                    ->counts('registrationMovements')
                    ->sortable()
                    ->toggleable()
                    ->visibleFrom('sm'),
                IconColumn::make('stripe_customer_id')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->visibleFrom('sm'),
                IconColumn::make('arrived_at')
                    ->label('Arrivé')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->visibleFrom('sm'),
                IconColumn::make('authenticated_at')
                    ->label("Connecté")
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->visibleFrom('sm'),
            ])
            ->filters([
                TernaryFilter::make('is_registered')
                    ->queries(
                        true: fn(Builder $query) => $query->has('registrationMovements'),
                        false: fn(Builder $query) => $query->doesntHave('registrationMovements'),
                        blank: fn(Builder $query) => $query,
                    ),
                TernaryFilter::make('is_arrived')
                    ->queries(
                        true: fn(Builder $query) => $query->whereNotNull('arrived_at'),
                        false: fn(Builder $query) => $query->whereNull('arrived_at'),
                        blank: fn(Builder $query) => $query,
                    ),
                TernaryFilter::make('is_authenticated')
                    ->queries(
                        true: fn(Builder $query) => $query->whereNotNull('authenticated_at'),
                        false: fn(Builder $query) => $query->whereNull('authenticated_at'),
                        blank: fn(Builder $query) => $query,
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
