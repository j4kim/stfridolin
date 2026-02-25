<?php

namespace App\Filament\Resources\Occurrences\RelationManagers;

use App\Filament\Resources\Competitors\CompetitorResource;
use App\Filament\Resources\Competitors\Tables\MarbleCompetitorsTable;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class CompetitorsRelationManager extends RelationManager
{
    protected static string $relationship = 'competitors';

    protected static ?string $relatedResource = CompetitorResource::class;

    public function isReadOnly(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                AttachAction::make()
                    ->tableSelect(MarbleCompetitorsTable::class)
                    ->multiple(),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
