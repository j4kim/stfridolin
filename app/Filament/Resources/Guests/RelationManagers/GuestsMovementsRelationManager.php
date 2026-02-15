<?php

namespace App\Filament\Resources\Guests\RelationManagers;

use App\Enums\ArticleType;
use App\Enums\MovementType;
use App\Filament\Resources\Movements\MovementResource;
use App\Models\Article;
use App\Models\Guest;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
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
                            ->visible(fn(Get $get) => $get('type') && $get('type') !== MovementType::Manual),
                        Grid::make()
                            ->columns(3)
                            ->schema([
                                TextInput::make('chf')->numeric(),
                                TextInput::make('tokens')->numeric(),
                                TextInput::make('points')->numeric(),
                            ])
                            ->visible(fn(Get $get) => $get('type') === MovementType::Manual),
                        TextInput::make('comment'),
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
                        $article = isset($data['article_id']) ? Article::find($data['article_id']) : null;

                        $movementData = [
                            'type' => $type,
                            'article_id' => $article?->id,
                            'meta' => ['source' => 'admin panel'],
                        ];

                        if ($data['created_at']) {
                            $movementData['created_at'] = $data['created_at'];
                        }

                        if ($data['comment']) {
                            $movementData['meta']['comment'] = $data['comment'];
                        }

                        if ($type === MovementType::Registration) {
                            $movementData['chf'] = -$article->price;
                            $movementData['tokens'] = 20;
                        } else if ($type === MovementType::BuyTokens) {
                            $movementData['chf'] = -$article->price;
                            $movementData['tokens'] = $article->meta['tokens'];
                        } else if ($type === MovementType::SpendTokens) {
                            $movementData['tokens'] = -$article->price;
                        } else if ($type === MovementType::Manual) {
                            $movementData['chf'] = $data['chf'];
                            $movementData['tokens'] = $data['tokens'];
                            $movementData['points'] = $data['points'];
                        } else {
                            throw new Exception("Type $type->name not implemented");
                        }

                        $guest->createMovement($movementData);
                    })
            ]);
    }
}
