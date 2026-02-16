<?php

namespace App\Filament\Resources\Guests\Tables;

use App\Filament\Tools\ColumnTools;
use App\Models\Guest;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
                TernaryFilter::make('registered')
                    ->queries(
                        true: fn(Builder $query) => $query->has('registrationMovements'),
                        false: fn(Builder $query) => $query->doesntHave('registrationMovements'),
                        blank: fn(Builder $query) => $query,
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make("Créer clients Stripe")
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each(
                                function (Guest $guest) {
                                    if ($guest->stripe_customer_id) {
                                        return;
                                    }
                                    $guest->createStripeCustomer()->save();
                                }
                            );
                        })
                        ->successNotificationTitle('Clients Stripe créés')
                        ->failureNotificationTitle(function (int $successCount, int $totalCount): string {
                            if ($successCount) {
                                return "{$successCount} sur {$totalCount} clients créés";
                            }

                            return 'Impossible de créer les clients Stripe';
                        }),
                ]),
            ]);
    }
}
