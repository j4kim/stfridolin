<?php

namespace App\Filament\Resources\Guests\Tables;

use App\Enums\ArticleType;
use App\Enums\GuestType;
use App\Enums\MovementType;
use App\Filament\Tools\ColumnTools;
use App\Models\Article;
use App\Models\Guest;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GuestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
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
                TextColumn::make('type')
                    ->badge()
                    ->sortable()
                    ->toggleable()
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
                SelectFilter::make('type')->options(GuestType::class),
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
                    BulkAction::make('Modifier type')
                        ->schema([Select::make('type')->options(GuestType::class)])
                        ->modalWidth(Width::Medium)
                        ->action(fn(Collection $records, array $data) => $records->each->update($data)),
                    BulkAction::make('Valider inscription')
                        ->requiresConfirmation()
                        ->modalWidth(Width::Medium)
                        ->action(function (Collection $records) {
                            $article = Article::firstWhere('type', ArticleType::Registration);
                            foreach ($records as $guest) {
                                if ($guest->registrationMovements()->exists()) {
                                    continue;
                                }
                                $guest->createMovement([
                                    'type' => MovementType::Registration,
                                    'article_id' => $article->id,
                                    'chf' => $guest->type === GuestType::Guest ? -30 : null,
                                    'tokens' => $guest->type === GuestType::Volunteer ? 100 : $article->meta['tokens'],
                                    'meta' => ['source' => 'admin panel'],
                                ]);
                            }
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
