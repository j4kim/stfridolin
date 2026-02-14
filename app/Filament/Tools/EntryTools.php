<?php

namespace App\Filament\Tools;

use App\Filament\Resources\Articles\ArticleResource;
use App\Filament\Resources\Guests\GuestResource;
use App\Models\Article;
use App\Models\Guest;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;

class EntryTools
{

    public static function compactSection(?string $heading = null): Section
    {
        return Section::make($heading)
            ->compact()
            ->columnSpanFull()
            ->columns(2);
    }


    public static function systemSection(): Section
    {
        return self::compactSection('System data')
            ->schema([
                TextEntry::make('id'),
                TextEntry::make('created_at')
                    ->dateTime("d.m.Y H:i")
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime("d.m.Y H:i")
                    ->placeholder('-'),
            ])
            ->columns(3)
            ->collapsible()
            ->persistCollapsed();
    }

    public static function guestLink(): TextEntry
    {
        return TextEntry::make('guest')
            ->url(fn(Guest $state): string => GuestResource::getUrl('view', ['record' => $state]))
            ->formatStateUsing(fn(Guest $state): string => $state->name);
    }

    public static function articleLink(): TextEntry
    {
        return TextEntry::make('article')
            ->url(fn(Article $state): string => ArticleResource::getUrl('view', ['record' => $state]))
            ->formatStateUsing(fn(Article $state): string => $state->description);
    }
}
