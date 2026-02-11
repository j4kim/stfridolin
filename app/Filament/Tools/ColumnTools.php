<?php

namespace App\Filament\Tools;

use Filament\Tables\Columns\TextColumn;

class ColumnTools
{
    public static function systemColumns(): array
    {
        return [
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
        ];
    }
}
