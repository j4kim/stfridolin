<?php

namespace App\Filament\Resources\Occurrences\Schemas;

use App\Filament\Resources\Games\GameResource;
use App\Filament\Tools\EntryTools;
use App\Models\Game;
use Dom\Text;
use Filament\Infolists\Components\Entry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OccurrenceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                EntryTools::systemSection(),

                EntryTools::compactSection()
                    ->schema([
                        EntryTools::gameLink(),
                        TextEntry::make('title'),
                        TextEntry::make('start_at')->dateTime('d.m.Y H:i'),
                        TextEntry::make('end_at')->dateTime('d.m.Y H:i'),
                        TextEntry::make('status')->badge(),
                        KeyValueEntry::make('meta'),
                        KeyValueEntry::make('ranking')
                            ->keyLabel('ID concurrent')
                            ->valueLabel('Rang'),
                    ])
            ]);
    }
}
