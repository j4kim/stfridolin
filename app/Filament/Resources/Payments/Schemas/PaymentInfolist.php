<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Filament\Resources\Guests\GuestResource;
use App\Filament\Tools\EntryTools;
use App\Models\Guest;
use App\Models\Payment;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                EntryTools::systemSection(),

                EntryTools::compactSection()->schema([
                    TextEntry::make('guest')
                        ->url(fn(Guest $state): string => GuestResource::getUrl('view', ['record' => $state]))
                        ->formatStateUsing(fn(Guest $state): string => $state->name),
                    TextEntry::make('stripe_status')
                        ->badge(),
                    TextEntry::make('purpose')
                        ->badge(),
                    TextEntry::make('amount')
                        ->numeric(),
                ]),


                EntryTools::compactSection("Stripe data")->schema([
                    TextEntry::make('stripe_id')->columnSpanFull(),
                    KeyValueEntry::make('Stripe data')
                        ->state(fn(Payment $payment) => collect($payment->stripe_data)->except('metadata')),
                    KeyValueEntry::make('stripe_data.metadata'),
                ]),
            ]);
    }
}
