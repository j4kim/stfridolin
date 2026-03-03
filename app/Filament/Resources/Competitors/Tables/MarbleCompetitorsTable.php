<?php

namespace App\Filament\Resources\Competitors\Tables;

use App\Enums\CompetitorType;
use App\Filament\Tools\ColumnTools;
use App\Models\Competitor;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MarbleCompetitorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk("public"),
            ])->filters([
                SelectFilter::make('type')
                    ->options(CompetitorType::class)
                    ->default(CompetitorType::Marble),
            ]);
    }
}
