<?php

namespace App\Filament\Resources\Competitors\Schemas;

use App\Filament\Tools\EntryTools;
use Filament\Infolists\Components\Entry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CompetitorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                EntryTools::systemSection(),

                EntryTools::compactSection()
                    ->schema([
                        TextEntry::make('name'),
                        ImageEntry::make('image_path')
                            ->label('Image')
                            ->placeholder('-')
                            ->disk('public')
                            ->visibility('public'),
                    ]),
            ]);
    }
}
