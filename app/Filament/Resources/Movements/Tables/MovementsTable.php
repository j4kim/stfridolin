<?php

namespace App\Filament\Resources\Movements\Tables;

use App\Enums\MovementType;
use App\Filament\Resources\Guests\RelationManagers\MovementsRelationManager;
use App\Filament\Tools\ColumnTools;
use App\Filament\Tools\Helpers;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MovementsTable
{
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
                TextColumn::make('chf')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(Helpers::signedFormatter())
                    ->summarize([Sum::make(), Average::make()]),
                TextColumn::make('tokens')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(Helpers::signedFormatter())
                    ->summarize([Sum::make(), Average::make()]),
                TextColumn::make('points')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(Helpers::signedFormatter())
                    ->summarize([Sum::make(), Average::make()]),
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
