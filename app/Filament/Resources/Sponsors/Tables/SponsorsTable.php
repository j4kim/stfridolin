<?php

namespace App\Filament\Resources\Sponsors\Tables;

use App\Filament\Tools\ColumnTools;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SponsorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),
                TextColumn::make('name')
                    ->searchable(),
            ])
            ->filters([
                //
            ]);
    }
}
