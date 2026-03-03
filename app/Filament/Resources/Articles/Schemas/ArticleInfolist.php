<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Filament\Tools\EntryTools;
use App\Filament\Tools\Helpers;
use Filament\Infolists\Components\Entry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ArticleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                EntryTools::systemSection(),

                EntryTools::compactSection()->schema([
                    TextEntry::make('type')->badge(),
                    TextEntry::make('name'),
                    TextEntry::make('description'),
                    TextEntry::make('currency')->badge(),
                    TextEntry::make('std_price')->numeric(),
                    TextEntry::make('price')->numeric(),
                    TextEntry::make('discount')
                        ->formatStateUsing(fn($state) => "-$state%")
                        ->badge()
                        ->color(Helpers::discountColor()),
                    EntryTools::gameLink(),
                    KeyValueEntry::make('meta'),
                ]),
            ]);
    }
}
