<?php

namespace App\Filament\Resources\Movements\Tables;

use App\Enums\MovementType;
use App\Filament\Resources\Guests\RelationManagers\MovementsRelationManager;
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
            ->summarize([Sum::make(), Average::make()]);
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),
                ColumnTools::guestLinkColumn()
                    ->hiddenOn(MovementsRelationManager::class),
                ColumnTools::paymentLinkColumn(),
                ColumnTools::articleLinkColumn(),
                TextColumn::make('type')
                    ->badge()
                    ->searchable(),
                self::currencyColumn('chf'),
                self::currencyColumn('tokens'),
                self::currencyColumn('points'),
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
