<?php

namespace App\Filament\Resources\Sponsors\Schemas;

use App\Filament\Tools\EntryTools;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SponsorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                EntryTools::systemSection(),

                EntryTools::compactSection()->schema([
                    TextEntry::make('name'),
                ]),
            ]);
    }
}
