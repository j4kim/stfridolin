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
                TextColumn::make('id')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime("d.m.Y H:i")
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime("d.m.Y H:i")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('article.description')
                    ->searchable(),
                ColumnTools::guestLinkColumn(),
            ])
            ->filters([
                TernaryFilter::make('guest_id')
                    ->label("Utilisé")
                    ->nullable(),
            ]);
    }
}
