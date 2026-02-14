<?php

namespace App\Filament\Resources\Guests\Schemas;

use App\Filament\Resources\Movements\MovementResource;
use App\Filament\Tools\EntryTools;
use App\Models\Movement;
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
                    TextEntry::make('registrationMovements')
                        ->bulleted()
                        ->formatStateUsing(fn(Movement $state) => "$state->id - {$state->created_at->format('d.m.Y')}")
                        ->url(fn(Movement $state): string => MovementResource::getUrl('view', ['record' => $state])),
                ]),
            ]);
    }
}
