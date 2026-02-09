<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('guest.name')
                    ->label('Guest'),
                TextEntry::make('stripe_id'),
                TextEntry::make('stripe_status')
                    ->placeholder('-'),
                TextEntry::make('purpose')
                    ->placeholder('-'),
                TextEntry::make('amount')
                    ->numeric(),
            ]);
    }
}
