<?php

namespace App\Filament\Resources\Occurrences\RelationManagers;

use App\Enums\MovementType;
use App\Filament\Resources\Movements\MovementResource;
use App\Filament\Tools\ColumnTools;
use App\Filament\Tools\Helpers;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';

    protected static ?string $relatedResource = MovementResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                ...ColumnTools::systemColumns(),
                ColumnTools::guestLinkColumn(),
                TextColumn::make('type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('tokens')
                    ->formatStateUsing(Helpers::signedFormatter())
                    ->numeric()
                    ->sortable(),
                TextColumn::make('points')
                    ->formatStateUsing(Helpers::signedFormatter())
                    ->numeric()
                    ->sortable(),
                TextColumn::make('competitor.name')
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
