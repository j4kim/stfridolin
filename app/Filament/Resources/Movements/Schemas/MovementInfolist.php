<?php

namespace App\Filament\Resources\Movements\Schemas;

use App\Filament\Resources\Articles\ArticleResource;
use App\Filament\Resources\Payments\PaymentResource;
use App\Filament\Tools\EntryTools;
use App\Models\Article;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MovementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                EntryTools::systemSection(),

                EntryTools::compactSection()->schema([
                    EntryTools::guestLink(),
                    TextEntry::make('payment_id')
                        ->numeric()
                        ->url(fn(int $state): string => PaymentResource::getUrl('view', ['record' => $state]))
                        ->placeholder('-'),
                    TextEntry::make('article')
                        ->formatStateUsing(fn(Article $state) => "$state->id - $state->name")
                        ->url(fn(Article $state): string => ArticleResource::getUrl('view', ['record' => $state])),
                    TextEntry::make('amount')->numeric(),
                    TextEntry::make('type')->badge(),
                ]),
            ]);
    }
}
