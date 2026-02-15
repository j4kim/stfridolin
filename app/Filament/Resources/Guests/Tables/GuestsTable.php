<?php

namespace App\Filament\Resources\Guests\Tables;

use App\Filament\Tools\ColumnTools;
use App\Models\Guest;
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
                    ->url(fn(int $state, Guest $guest): ?string => $state ? $guest->paymentsUrl() : null)
                    ->summarize([Sum::make(), Average::make()])
                    ->visibleFrom('sm'),
                TextColumn::make('movements_count')
                    ->counts('movements')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->url(fn(int $state, Guest $guest): ?string => $state ? $guest->movementsUrl() : null)
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
            ])
            ->filters([
                TernaryFilter::make('registered')
                    ->queries(
                        true: fn(Builder $query) => $query->has('registrationMovements'),
                        false: fn(Builder $query) => $query->doesntHave('registrationMovements'),
                        blank: fn(Builder $query) => $query,
                    ),
            ]);
    }
}
