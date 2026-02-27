<?php

namespace App\Filament\Tools;

use App\Filament\Resources\Articles\ArticleResource;
use App\Filament\Resources\Competitors\CompetitorResource;
use App\Filament\Resources\Games\GameResource;
use App\Filament\Resources\Guests\GuestResource;
use App\Filament\Resources\Occurrences\OccurrenceResource;
use App\Filament\Resources\Payments\PaymentResource;
use App\Models\Article;
use App\Models\Competitor;
use App\Models\Fight;
use App\Models\Game;
use App\Models\Guest;
use App\Models\Occurrence;
use App\Models\Track;
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

    public static function gameLink(): TextEntry
    {
        return TextEntry::make('game')
            ->url(fn(Game $state): string => GameResource::getUrl('view', ['record' => $state]))
            ->formatStateUsing(fn(Game $state): string => $state->title);
    }

    public static function paymentLink(): TextEntry
    {
        return TextEntry::make('payment_id')
            ->numeric()
            ->url(fn(int $state): string => PaymentResource::getUrl('view', ['record' => $state]))
            ->placeholder('-');
    }

    public static function occurrenceLink(): TextEntry
    {
        return TextEntry::make('occurrence')
            ->url(fn(Occurrence $state): string => OccurrenceResource::getUrl('view', ['record' => $state]))
            ->formatStateUsing(fn(Occurrence $state): string => $state->title);
    }

    public static function competitorLink(): TextEntry
    {
        return TextEntry::make('competitor')
            ->url(fn(Competitor $state): string => CompetitorResource::getUrl('view', ['record' => $state]))
            ->formatStateUsing(fn(Competitor $state): string => $state->name);
    }

    public static function fightLink(): TextEntry
    {
        return TextEntry::make('fight')
            ->formatStateUsing(fn(Fight $state): string => "#$state->id {$state->leftTrack->name} vs {$state->rightTrack->name}");
    }

    public static function trackLink(): TextEntry
    {
        return TextEntry::make('track')
            ->formatStateUsing(fn(Track $state): string => "$state->name by $state->artist_name");
    }
}
