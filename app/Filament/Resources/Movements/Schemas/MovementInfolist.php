<?php

namespace App\Filament\Resources\Movements\Schemas;

use App\Filament\Resources\Articles\ArticleResource;
use App\Filament\Resources\Payments\PaymentResource;
use App\Filament\Tools\EntryTools;
use App\Filament\Tools\Helpers;
use App\Models\Article;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MovementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                EntryTools::systemSection(),

                EntryTools::compactSection('Détails')->schema([
                    TextEntry::make('chf')->formatStateUsing(Helpers::signedFormatter()),
                    TextEntry::make('tokens')->formatStateUsing(Helpers::signedFormatter()),
                    TextEntry::make('points')->formatStateUsing(Helpers::signedFormatter()),
                ])->columns(3),

                EntryTools::compactSection()->schema([
                    EntryTools::guestLink(),
                    EntryTools::paymentLink(),
                    EntryTools::articleLink(),
                    TextEntry::make('type')->badge(),
                    KeyValueEntry::make('meta'),
                ]),
            ]);
    }
}
