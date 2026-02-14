<?php

namespace App\Filament\Resources\Vouchers\Tables;

use App\Filament\Tools\ColumnTools;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class VouchersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),
                TextColumn::make('article.description')
                    ->searchable(),
                TextColumn::make('guest.name')
                    ->searchable(),
            ])
            ->filters([
                TernaryFilter::make('guest_id')
                    ->label("Utilisé")
                    ->nullable()
                    ->default(false)
            ]);
    }
}
