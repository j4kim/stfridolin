<?php

namespace App\Filament\Resources\Games\Tables;

use App\Filament\Resources\Occurrences\OccurrenceResource;
use App\Filament\Tools\ColumnTools;
use App\Models\Game;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GamesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),
                TextColumn::make('name')
                    ->searchable()
                    ->visibleFrom('sm'),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('occurrences_count')
                    ->counts('occurrences')
                    ->label('Occ.s')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->url(fn(int $state, Game $game) => OccurrenceResource::getUrl('index', [
                        'filters' => ['game' => ['value' => $game->id]]
                    ]))
                    ->visibleFrom('sm'),
            ])
            ->filters([
                //
            ]);
    }
}
