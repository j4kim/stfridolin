<?php

namespace App\Filament\Resources\Guests\RelationManagers;

use App\Enums\ArticleType;
use App\Enums\MovementType;
use App\Filament\Resources\Movements\MovementResource;
use App\Models\Article;
use App\Models\Guest;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
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

        if ($data['created_at']) {
            $movementData['created_at'] = $data['created_at'];
        }

        if ($data['comment']) {
            $movementData['meta']['comment'] = $data['comment'];
        }

        $guest->createMovement($movementData);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                Action::make("manual")
                    ->label("Mouvement manuel")
                    ->icon(Heroicon::Plus)
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

                Action::make("regristration")
                    ->label("Inscription")
                    ->icon(Heroicon::Plus)
                    ->modalWidth(Width::Large)
                    ->schema(self::commonActionFields())
                    ->action(fn(array $data) => $this->createGuestMovement($data, MovementType::Registration))
                    ->hidden(fn() => $this->getOwnerRecord()->registrationMovements()->exists()),
            ]);
    }


    public static function getTabComponent(Model $ownerRecord, string $pageClass): Tab
    {
        return Tab::make('Mouvements')
            ->badge($ownerRecord->movements()->count())
            ->icon(Heroicon::ArrowsUpDown);
    }
}
