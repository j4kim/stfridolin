<?php

namespace App\Filament\Resources\Articles\Tables;

use App\Enums\ArticleType;
use App\Filament\Tools\ColumnTools;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('std_price')
                    ->numeric()
                    ->sortable(),
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
                    ->formatStateUsing(fn(float $state): string => "-$state%"),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(ArticleType::class),
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
