<?php

namespace App\Filament\Resources\Articles\RelationManagers;

use App\Filament\Resources\Movements\MovementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class ArticlesMovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';

    protected static ?string $relatedResource = MovementResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
