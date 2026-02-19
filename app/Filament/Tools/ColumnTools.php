<?php

namespace App\Filament\Tools;

use App\Filament\Resources\Articles\ArticleResource;
use App\Filament\Resources\Guests\GuestResource;
use App\Filament\Resources\Movements\MovementResource;
use App\Filament\Resources\Payments\PaymentResource;
use App\Models\Article;
use App\Models\Guest;
use Filament\Tables\Columns\TextColumn;

class ColumnTools
{
    public static function systemColumns(): array
    {
        return [
            TextColumn::make('id')
                ->numeric()
                ->sortable()
                ->toggleable()
                ->visibleFrom('sm'),
            TextColumn::make('created_at')
                ->dateTime("d.m.Y H:i")
                ->sortable()
                ->toggleable()
                ->visibleFrom('sm'),
            TextColumn::make('updated_at')
                ->dateTime("d.m.Y H:i")
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->visibleFrom('sm'),
        ];
    }

    public static function guestLinkColumn(): TextColumn
    {
        return TextColumn::make('guest')
            ->url(fn(Guest $state): string => GuestResource::getUrl('view', ['record' => $state]))
            ->formatStateUsing(fn(Guest $state): string => $state->name);
    }

    public static function paymentLinkColumn(): TextColumn
    {
        return TextColumn::make('payment_id')
            ->numeric()
            ->url(fn(int $state): string => PaymentResource::getUrl('view', ['record' => $state]))
            ->sortable();
    }

    public static function articleLinkColumn(): TextColumn
    {
        return TextColumn::make('article')
            ->url(fn(Article $state): string => ArticleResource::getUrl('view', ['record' => $state]))
            ->formatStateUsing(fn(Article $state): string => $state->description);
    }

    public static function movementsUrl($col, $id): string
    {
        return MovementResource::getUrl('index', [
            'filters' => [$col => ['value' => $id]]
        ]);
    }

    public static function paymentsUrl($col, $id): string
    {
        return PaymentResource::getUrl('index', [
            'filters' => [$col => ['value' => $id]]
        ]);
    }

    public static function tooltipped($name, $limit = 20): TextColumn
    {
        return TextColumn::make($name)
            ->limit($limit)
            ->tooltip(function (TextColumn $column): ?string {
                $state = $column->getState();

                if (strlen($state) <= $column->getCharacterLimit()) {
                    return null;
                }

                // Only render the tooltip if the column contents exceeds the length limit.
                return $state;
            });
    }
}
