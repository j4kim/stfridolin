<?php

namespace App\Filament\Resources\Occurrences\Schemas;

use App\Filament\Resources\Games\GameResource;
use App\Filament\Tools\EntryTools;
use App\Models\Game;
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
                        TextEntry::make('game')
                            ->url(fn(Game $state): string => GameResource::getUrl('view', ['record' => $state]))
                            ->formatStateUsing(fn(Game $state): string => $state->name),
                        TextEntry::make('title'),
                        TextEntry::make('start_at')->dateTime('d.m.Y H:i'),
                        TextEntry::make('end_at')->dateTime('d.m.Y H:i'),
                        KeyValueEntry::make('meta'),
                    ])
            ]);
    }
}
