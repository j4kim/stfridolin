<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Enums\ArticleType;
use App\Enums\Currency;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->options(ArticleType::class)
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('description'),
                Select::make('currency')
                    ->options(Currency::class)
                    ->required(),
                TextInput::make('std_price')
                    ->numeric(),
                TextInput::make('price')
                    ->required()
                    ->numeric(),
                KeyValue::make('meta'),
            ]);
    }
}
