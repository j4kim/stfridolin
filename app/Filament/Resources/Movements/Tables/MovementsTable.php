<?php

namespace App\Filament\Resources\Movements\Tables;

use App\Enums\MovementType;
use App\Filament\Resources\Articles\ArticleResource;
use App\Filament\Resources\Guests\GuestResource;
use App\Filament\Resources\Payments\PaymentResource;
use App\Filament\Tools\ColumnTools;
use App\Filament\Tools\Helpers;
use App\Models\Article;
use App\Models\Guest;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MovementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ...ColumnTools::systemColumns(),
                TextColumn::make('guest')
                    ->url(fn(Guest $state): string => GuestResource::getUrl('view', ['record' => $state]))
                    ->formatStateUsing(fn(Guest $state): string => $state->name),
                TextColumn::make('payment_id')
                    ->numeric()
                    ->url(fn(int $state): string => PaymentResource::getUrl('view', ['record' => $state]))
                    ->sortable(),
                TextColumn::make('article')
                    ->url(fn(Article $state): string => ArticleResource::getUrl('view', ['record' => $state]))
                    ->formatStateUsing(fn(Article $state): string => $state->description),
                TextColumn::make('type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('chf')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(Helpers::signedFormatter()),
                TextColumn::make('tokens')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(Helpers::signedFormatter()),
                TextColumn::make('points')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(Helpers::signedFormatter()),
            ])
            ->filters([
                SelectFilter::make('guest')
                    ->relationship('guest', 'name'),
                SelectFilter::make('article')
                    ->relationship('article', 'description'),
                SelectFilter::make('type')
                    ->options(MovementType::class),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
