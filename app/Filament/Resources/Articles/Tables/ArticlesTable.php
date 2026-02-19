<?php

namespace App\Filament\Resources\Articles\Tables;

use App\Enums\ArticleType;
use App\Filament\Tools\ColumnTools;
use App\Filament\Tools\Helpers;
use App\Models\Article;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),
                TextColumn::make('type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable()
                    ->visibleFrom('sm'),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('std_price')
                    ->numeric()
                    ->sortable()
                    ->visibleFrom('sm'),
                TextColumn::make('price')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('currency')
                    ->badge()
                    ->searchable(),
                TextColumn::make('discount')
                    ->sortable(
                        query: fn(Builder $query, string $direction): Builder =>
                        $query
                            ->orderByRaw("(ifnull(std_price, price) - price) / ifnull(std_price, price) $direction")
                    )
                    ->formatStateUsing(fn($state) => "-$state%")
                    ->badge()
                    ->color(Helpers::discountColor())
                    ->visibleFrom('sm'),
                TextColumn::make('movements_count')
                    ->counts('movements')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->url(fn(int $state, Article $art) => ColumnTools::movementsUrl('article', $art->id))
                    ->visibleFrom('sm'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(ArticleType::class),
            ]);
    }
}
