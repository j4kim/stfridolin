<?php

namespace App\Filament\Resources\Occurrences\Tables;

use App\Filament\Resources\Games\GameResource;
use App\Filament\Resources\Games\RelationManagers\OccurrencesRelationManager;
use App\Filament\Tools\ColumnTools;
use Dom\Text;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OccurrencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),

                ColumnTools::gameLinkColumn(),
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('start_at')->dateTime("d.m.Y H:i")->sortable(),
                TextColumn::make('end_at')->dateTime("d.m.Y H:i")->sortable(),
                TextColumn::make('status')->badge(),
            ])
            ->defaultSort('start_at', direction: 'asc')
            ->filters([
                SelectFilter::make('game')
                    ->relationship('game', 'name'),
            ]);
    }
}
