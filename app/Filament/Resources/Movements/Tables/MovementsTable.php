<?php

namespace App\Filament\Resources\Movements\Tables;

use App\Filament\Tools\ColumnTools;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MovementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),
                TextColumn::make('guest.name')
                    ->searchable(),
                TextColumn::make('payment_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('article.description')
                    ->searchable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('guest')
                    ->relationship('guest', 'name'),
                SelectFilter::make('article')
                    ->relationship('article', 'description'),
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
