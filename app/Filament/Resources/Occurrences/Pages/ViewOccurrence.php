<?php

namespace App\Filament\Resources\Occurrences\Pages;

use App\Filament\Resources\Occurrences\OccurrenceResource;
use App\Filament\Resources\Occurrences\RelationManagers\CompetitorsRelationManager;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOccurrence extends ViewRecord
{
    protected static string $resource = OccurrenceResource::class;

    public function getRelationManagers(): array
    {
        return [
            CompetitorsRelationManager::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
