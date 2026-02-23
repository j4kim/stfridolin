<?php

namespace App\Filament\Resources\Occurrences\Tables;

use App\Filament\Tools\ColumnTools;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OccurrencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),

                TextColumn::make('title'),
                TextColumn::make('start_at')->dateTime("d.m.Y H:i"),
                TextColumn::make('end_at')->dateTime("d.m.Y H:i"),
            ])
            ->filters([
                //
            ]);
    }
}
