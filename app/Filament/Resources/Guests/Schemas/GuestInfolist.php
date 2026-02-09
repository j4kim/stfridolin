<?php

namespace App\Filament\Resources\Guests\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GuestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('name'),
                TextEntry::make('key'),
                TextEntry::make('pictureUrl')
                    ->placeholder('-'),
                TextEntry::make('tokens')
                    ->numeric(),
                TextEntry::make('points')
                    ->numeric(),
            ]);
    }
}
