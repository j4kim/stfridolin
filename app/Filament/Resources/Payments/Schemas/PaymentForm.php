<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('guest_id')
                    ->relationship('guest', 'name')
                    ->required(),
                TextInput::make('stripe_id')
                    ->required(),
                TextInput::make('stripe_status'),
                TextInput::make('stripe_data')
                    ->required(),
                TextInput::make('purpose'),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
            ]);
    }
}
