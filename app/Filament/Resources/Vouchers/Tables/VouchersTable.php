<?php

namespace App\Filament\Resources\Vouchers\Tables;

use App\Enums\ArticleType;
use App\Filament\Tools\ColumnTools;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VouchersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime("d.m.Y H:i")
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime("d.m.Y H:i")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('article.description')
                    ->searchable(),
                TextColumn::make('article.type')
                    ->label(__("article_type"))
                    ->badge(),
                ColumnTools::guestLinkColumn(),
            ])
            ->filters([
                TernaryFilter::make('guest_id')
                    ->label("Utilisé")
                    ->nullable(),
                SelectFilter::make('article_type')
                    ->options(ArticleType::class)
                    ->query(function (Builder $query, array $data): Builder {
                        $type = @$data['value'];
                        if (!$type) return $query;
                        return $query->whereRelation('article', 'type', $type);
                    }),
            ])->recordActions([
                ViewAction::make(),
            ]);
    }
}
