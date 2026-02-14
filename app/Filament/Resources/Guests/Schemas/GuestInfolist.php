<?php

namespace App\Filament\Resources\Guests\Schemas;

use App\Filament\Tools\EntryTools;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GuestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                EntryTools::systemSection(),

                EntryTools::compactSection()->schema([
                    TextEntry::make('name'),
                    TextEntry::make('key'),
                    TextEntry::make('tokens')
                        ->numeric(),
                    TextEntry::make('points')
                        ->numeric(),
                ]),
            ]);
    }
}
