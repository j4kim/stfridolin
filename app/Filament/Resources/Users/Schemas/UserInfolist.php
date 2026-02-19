<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Tools\EntryTools;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                EntryTools::systemSection(),

                EntryTools::compactSection()->schema([
                    TextEntry::make('name'),
                    TextEntry::make('email')
                        ->label('Email address'),
                    TextEntry::make('email_verified_at')
                        ->dateTime("d.m.Y H:i")
                        ->placeholder('-')
                ]),
            ]);
    }
}
