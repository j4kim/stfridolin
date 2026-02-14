<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Filament\Tools\EntryTools;
use App\Models\Article;
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
                    TextEntry::make('discount')->formatStateUsing(fn($state) => "-$state%"),
                    TextEntry::make('std_price')
                        ->formatStateUsing(
                            fn($state, Article $article) => "$state {$article->currency->value}"
                        ),
                    TextEntry::make('price')->formatStateUsing(
                        fn($state, Article $article) => "$state {$article->currency->value}"
                    ),
                ]),
            ]);
    }
}
