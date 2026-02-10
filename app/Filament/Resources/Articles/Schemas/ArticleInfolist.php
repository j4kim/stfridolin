<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ArticleInfolist
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
                TextEntry::make('type'),
                TextEntry::make('name'),
                TextEntry::make('description')
                    ->placeholder('-'),
                TextEntry::make('currency'),
                TextEntry::make('std_price')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('price')
                    ->money(),
            ]);
    }
}
