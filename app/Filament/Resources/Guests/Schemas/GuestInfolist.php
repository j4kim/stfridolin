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
                            return Action::make('create stripe customer')
                                ->action(function (Guest $guest) {
                                    $guest->createStripeCustomer()->save();
                                });
                        }),
                ]),
            ]);
    }
}
