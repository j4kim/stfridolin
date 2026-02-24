<?php

namespace App\Filament\Resources\Games\Schemas;

use App\Filament\Tools\EntryTools;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GameInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                EntryTools::systemSection(),

                EntryTools::compactSection()
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('type')->badge(),
                        TextEntry::make('title'),
                        TextEntry::make('description'),
                        KeyValueEntry::make('meta'),
                    ])
            ]);
    }
}
