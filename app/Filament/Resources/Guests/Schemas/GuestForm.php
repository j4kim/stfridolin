<?php

namespace App\Filament\Resources\Guests\Schemas;

use App\Enums\GuestType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GuestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('key'),
                DateTimePicker::make('arrived_at')
                    ->displayFormat('Y.m.d H:i')
                    ->seconds(false),
                Select::make('type')
                    ->options(GuestType::class)
                    ->required(),
            ]);
    }
}
