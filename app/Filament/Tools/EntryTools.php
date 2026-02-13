<?php

namespace App\Filament\Tools;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;

class EntryTools
{
    public static function systemSection(): Section
    {
        return Section::make('System data')
            ->schema([
                TextEntry::make('id'),
                TextEntry::make('created_at')
                    ->dateTime("d.m.Y H:i")
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime("d.m.Y H:i")
                    ->placeholder('-'),
            ])
            ->columns(3)
            ->columnSpanFull()
            ->collapsible()
            ->persistCollapsed()
            ->compact();
    }
}
