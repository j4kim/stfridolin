<?php

namespace App\Filament\Resources\Occurrences\Schemas;

use App\Enums\OccurrenceType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OccurrenceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('title'),
                DateTimePicker::make('start_at'),
                DateTimePicker::make('end_at'),
                KeyValue::make('meta'),
            ]);
    }
}
