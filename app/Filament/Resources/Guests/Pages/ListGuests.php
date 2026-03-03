<?php

namespace App\Filament\Resources\Guests\Pages;

use App\Enums\GuestType;
use App\Filament\Resources\Guests\GuestResource;
use App\Models\Guest;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListGuests extends ListRecords
{
    protected static string $resource = GuestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),

            Action::make('create_many_guests')
                ->label("Créer des invités anonymes")
                ->schema([
                    Select::make('type')
                        ->options(GuestType::class)
                        ->required(),
                    TextInput::make('quantity')
                        ->label("Quantité")
                        ->numeric()
                        ->required()
                        ->default(9),
                ])
                ->action(function (array $data) {
                    Guest::factory($data['quantity'])->create(['name' => '_', 'type' => $data['type']]);
                    Notification::make()
                        ->title("$data[quantity] invités créés")
                        ->success()
                        ->send();
                })
                ->modalWidth(Width::Medium),
        ];
    }
}
