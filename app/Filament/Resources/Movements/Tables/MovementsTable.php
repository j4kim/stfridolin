<?php

namespace App\Filament\Resources\Movements\Tables;

use App\Enums\MovementType;
use App\Filament\Resources\Articles\RelationManagers\MovementsRelationManager as ArticlesMovementsRelationManager;
use App\Filament\Resources\Guests\RelationManagers\MovementsRelationManager as GuestsMovementsRelationManager;
use App\Filament\Tools\ColumnTools;
use App\Filament\Tools\Helpers;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MovementsTable
{
    public static function currencyColumn($name): TextColumn
    {
        return TextColumn::make($name)
            ->numeric()
            ->sortable()
            ->formatStateUsing(Helpers::signedFormatter())
            ->summarize([
                Sum::make()
                    ->formatStateUsing(fn($state) => "$state $name"),
                Average::make()
                    ->formatStateUsing(fn($state) => "$state $name")
                    ->numeric(decimalPlaces: 1)
            ]);
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),
                ColumnTools::guestLinkColumn()
                    ->hiddenOn(GuestsMovementsRelationManager::class),
                ColumnTools::paymentLinkColumn()->visibleFrom('sm'),
                ColumnTools::articleLinkColumn()
                    ->hiddenOn(ArticlesMovementsRelationManager::class),
                TextColumn::make('type')
                    ->badge()
                    ->searchable(),
                self::currencyColumn('chf')->visibleFrom('sm'),
                self::currencyColumn('tokens')->visibleFrom('sm'),
                self::currencyColumn('points')->visibleFrom('sm'),
            ])
            ->filters([
                SelectFilter::make('guest')
                    ->relationship('guest', 'name'),
                SelectFilter::make('article')
                    ->relationship('article', 'description'),
                SelectFilter::make('type')
                    ->options(MovementType::class),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
