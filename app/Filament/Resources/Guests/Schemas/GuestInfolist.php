<?php

namespace App\Filament\Resources\Guests\Schemas;

use App\Filament\Tools\EntryTools;
use App\Models\Guest;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GuestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                EntryTools::systemSection(),

                EntryTools::compactSection()->schema([
                    TextEntry::make('name'),
                    TextEntry::make('key'),
                    TextEntry::make('tokens')
                        ->numeric(),
                    TextEntry::make('points')
                        ->numeric(),
                    TextEntry::make('stripe_customer_id')
                        ->belowLabel(function (?string $state) {
                            if ($state) return null;
                            return Action::make('Créer client stripe')
                                ->action(function (Guest $guest) {
                                    $guest->createStripeCustomer()->save();
                                });
                        }),
                    TextEntry::make('arrived_at')
                        ->dateTime("d.m.Y H:i")
                        ->belowLabel(function (?string $state) {
                            if ($state) return null;
                            return Action::make('arrives_now')
                                ->action(function (Guest $guest) {
                                    $guest->update(['arrived_at' => now()]);
                                });
                        }),
                    TextEntry::make('authenticated_at')
                        ->dateTime("d.m.Y H:i")
                        ->placeholder('-'),
                ]),
            ]);
    }
}
