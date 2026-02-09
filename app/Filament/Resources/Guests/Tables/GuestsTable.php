<?php

namespace App\Filament\Resources\Guests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GuestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime("d.m.Y H:i")
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime("d.m.Y H:i")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('key')
                    ->searchable(),
                TextColumn::make('tokens')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('points')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payments_count')
                    ->label("Payments")
                    ->counts('payments')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('movements_count')
                    ->label("Movements")
                    ->counts('movements')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
            ])
            ->persistSortInSession()
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
