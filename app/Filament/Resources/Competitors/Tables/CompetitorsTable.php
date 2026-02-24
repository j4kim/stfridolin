<?php

namespace App\Filament\Resources\Competitors\Tables;

use App\Filament\Tools\ColumnTools;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompetitorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),
                TextColumn::make('name')
                    ->searchable(),
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk("public"),
                TextColumn::make('type')
                    ->badge()
                    ->toggleable()
                    ->visibleFrom('sm'),
            ])
            ->filters([
                //
            ]);
    }
}
