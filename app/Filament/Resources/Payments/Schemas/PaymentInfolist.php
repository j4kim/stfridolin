<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Filament\Resources\Movements\MovementResource;
use App\Filament\Tools\EntryTools;
use App\Models\Movement;
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
                    EntryTools::guestLink(),
                    EntryTools::articleLink(),
                    TextEntry::make('status')
                        ->badge(),
                    TextEntry::make('purpose')
                        ->badge(),
                    TextEntry::make('amount')
                        ->numeric(),
                    TextEntry::make('method')->badge(),
                    TextEntry::make('description'),
                    KeyValueEntry::make('meta'),
                    TextEntry::make('movements')
                        ->bulleted()
                        ->formatStateUsing(fn(Movement $state) => "$state->id - {$state->guest->name} - {$state->article->name}")
                        ->url(fn(Movement $state): string => MovementResource::getUrl('view', ['record' => $state])),
                ]),


                EntryTools::compactSection("Stripe data")->schema([
                    TextEntry::make('stripe_id'),
                    KeyValueEntry::make('stripe_data')
                        ->state(fn(Payment $payment) => collect($payment->stripe_data)->except('metadata')),
                ]),
            ]);
    }
}
