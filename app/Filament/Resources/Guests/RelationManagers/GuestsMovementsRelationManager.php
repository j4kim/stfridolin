<?php

namespace App\Filament\Resources\Guests\RelationManagers;

use App\Enums\ArticleType;
use App\Enums\MovementType;
use App\Filament\Resources\Movements\MovementResource;
use App\Models\Article;
use App\Models\Guest;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Enums\Width;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GuestsMovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';

    protected static ?string $relatedResource = MovementResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Action::make('Ajouter')
                    ->schema([
                        Select::make('type')
                            ->required()
                            ->options(MovementType::class)
                            ->live(),
                        Select::make('article_id')
                            ->required()
                            ->relationship('article', modifyQueryUsing: function (Builder $query, Get $get) {
                                $types = match ($get('type')) {
                                    MovementType::Registration => [ArticleType::Registration],
                                    MovementType::BuyTokens => [ArticleType::TokensPackage],
                                    MovementType::SpendTokens => [ArticleType::Jukeboxe],
                                    default => [],
                                };
                                $query->whereIn('type', $types);
                            })
                            ->getOptionLabelFromRecordUsing(fn(Article $a) => "$a->description ($a->price {$a->currency->value})")
                            ->disabled(fn(Get $get) => empty($get('type'))),
                        KeyValue::make('meta')
                            ->default(['source' => 'admin panel']),
                        DateTimePicker::make('created_at')
                            ->displayFormat('Y.m.d H:i')
                            ->seconds(false)
                            ->belowContent("Laissez vide pour utiliser la date et l'heure actuelle"),
                    ])
                    ->modalWidth(Width::Large)
                    ->action(function (array $data) {
                        /** @var Guest $guest */
                        $guest = $this->getOwnerRecord();

                        /** @var MovementType $type */
                        $type = $data['type'];

                        /** @var Article $article */
                        $article = Article::find($data['article_id']);

                        $movementData = [
                            'type' => $type,
                            'article_id' => $article->id,
                            'meta' => $data['meta'],
                        ];

                        if ($data['created_at']) {
                            $movementData['created_at'] = $data['created_at'];
                        }

                        if ($type === MovementType::Registration) {
                            $movementData['chf'] = -$article->price;
                            $movementData['tokens'] = 20;
                        } else if ($type === MovementType::BuyTokens) {
                            $movementData['chf'] = -$article->price;
                            $movementData['tokens'] = $article->meta['tokens'];
                        } else if ($type === MovementType::SpendTokens) {
                            $movementData['tokens'] = -$article->price;
                        }

                        $guest->createMovement($movementData);
                    })
            ]);
    }
}
