<?php

namespace App\Filament\Resources\Guests\RelationManagers;

use App\Filament\Resources\Movements\MovementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class GuestsMovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';

    protected static ?string $relatedResource = MovementResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([]);
    }
}
