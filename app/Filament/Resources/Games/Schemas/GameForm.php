<?php

namespace App\Filament\Resources\Games\Schemas;

use App\Enums\GameType;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GameForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options(GameType::class)
                    ->required(),
                TextInput::make('title'),
                Textarea::make('description'),
                KeyValue::make('meta'),
            ]);
    }
}
