<?php

namespace App\Filament\Resources\Games\RelationManagers;

use App\Filament\Resources\Movements\MovementResource;
use App\Filament\Tools\ColumnTools;
use App\Filament\Tools\Helpers;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';

    protected static ?string $relatedResource = MovementResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                ...ColumnTools::systemColumns(),
                ColumnTools::guestLinkColumn(),
                TextColumn::make('type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('tokens')
                    ->formatStateUsing(Helpers::signedFormatter())
                    ->numeric()
                    ->sortable(),
                TextColumn::make('points')
                    ->formatStateUsing(Helpers::signedFormatter())
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
