<?php

namespace App\Filament\Resources\Guests\RelationManagers;

use App\Enums\ArticleType;
use App\Enums\MovementType;
use App\Filament\Resources\Movements\MovementResource;
use App\Models\Article;
use App\Models\Guest;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Text;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GuestsMovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';

    protected static ?string $relatedResource = MovementResource::class;

    public function isReadOnly(): bool
    {
        return false;
    }

    public static function commonActionFields(): array
    {
        return [
            TextInput::make('comment'),
            DateTimePicker::make('created_at')
                ->displayFormat('Y.m.d H:i')
                ->seconds(false)
                ->belowContent("Laissez vide pour utiliser la date et l'heure actuelle"),
        ];
    }

    public function createGuestMovement(array $data, MovementType $type)
    {
        /** @var Guest $guest */
        $guest = $this->getOwnerRecord();

        $movementData = [
            'type' => $type,
            'chf' => @$data['chf'],
            'tokens' => @$data['tokens'],
            'points' => @$data['points'],
            'meta' => ['source' => 'admin panel'],
        ];

        if ($type === MovementType::Registration) {
            $article = Article::firstWhere('type', ArticleType::Registration);
            $movementData['article_id'] = $article->id;
            $movementData['chf'] = -$article->price;
            $movementData['tokens'] = $article->meta['tokens'];
        }

        if (isset($data['created_at'])) {
            $movementData['created_at'] = $data['created_at'];
        }

        if (isset($data['comment'])) {
            $movementData['meta']['comment'] = $data['comment'];
        }

        $guest->createMovement($movementData);

        return $this->redirect(request()->header('Referer'));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                Action::make("sub_tokens")
                    ->label("Jetons")
                    ->outlined()
                    ->icon(Heroicon::Minus)
                    ->modalWidth(Width::Medium)
                    ->modalHeading("Dépenser des jetons")
                    ->schema(function (): array {
                        $tokens = $this->getOwnerRecord()->tokens;
                        return [
                            TextEntry::make('tokens')->state($tokens)->label("Jetons actuel"),
                            TextInput::make('tokens')->label('Jetons dépensés')->numeric()->minValue(1)->maxValue($tokens)->required(),
                            TextInput::make('comment'),
                        ];
                    })
                    ->mutateDataUsing(function (array $data): array {
                        $data['tokens'] = -$data['tokens'];
                        return $data;
                    })
                    ->action(fn(array $data) => $this->createGuestMovement($data, MovementType::Manual)),

                Action::make("add_tokens")
                    ->label("Jetons")
                    ->outlined()
                    ->icon(Heroicon::Plus)
                    ->modalWidth(Width::Medium)
                    ->modalHeading("Ajouter des jetons")
                    ->schema([
                        TextEntry::make('tokens')->state($this->getOwnerRecord()->tokens)->label("Jetons actuel"),
                        TextInput::make('tokens')->label('Jetons crédités')->numeric()->minValue(1)->required(),
                        TextInput::make('comment'),
                    ])
                    ->action(fn(array $data) => $this->createGuestMovement($data, MovementType::Manual)),

                Action::make("add_regristration")
                    ->modalWidth(Width::Medium)
                    ->schema(self::commonActionFields())
                    ->action(fn(array $data) => $this->createGuestMovement($data, MovementType::Registration))
                    ->hidden(fn() => $this->getOwnerRecord()->registrationMovements()->exists()),

                ActionGroup::make([
                    Action::make("add_manual_movement")
                        ->outlined()
                        ->modalWidth(Width::Large)
                        ->schema([
                            Grid::make()
                                ->columns(3)
                                ->schema([
                                    TextInput::make('chf')->numeric(),
                                    TextInput::make('tokens')->numeric(),
                                    TextInput::make('points')->numeric(),
                                    Text::make("Nombre négatif pour une dépense, positif pour un crédit")->columnSpanFull(),
                                ]),
                            ...self::commonActionFields(),
                        ])
                        ->action(fn(array $data) => $this->createGuestMovement($data, MovementType::Manual)),
                ]),
            ]);
    }


    public static function getTabComponent(Model $ownerRecord, string $pageClass): Tab
    {
        return Tab::make('Mouvements')
            ->badge($ownerRecord->movements()->count())
            ->icon(Heroicon::ArrowsUpDown);
    }
}
