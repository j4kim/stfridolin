<?php

namespace App\Filament\Resources\Occurrences\Pages;

use App\Filament\Resources\Occurrences\OccurrenceResource;
use App\Filament\Resources\Occurrences\RelationManagers\CompetitorsRelationManager;
use App\Filament\Resources\Occurrences\RelationManagers\MovementsRelationManager;
use App\Models\Occurrence;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOccurrence extends ViewRecord
{
    protected static string $resource = OccurrenceResource::class;

    public function getRelationManagers(): array
    {
        return [
            CompetitorsRelationManager::class,
            MovementsRelationManager::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        /** @var Occurrence $occurrence */
        $occurrence = $this->record;
        /** @var Game $game */
        $game = $occurrence->game;
        $url = $game->frontEndUrl($occurrence->id);
        return [
            Action::make('open')
                ->label("Ouvrir sur l'app")
                ->url($url)
                ->link()
                ->visible(!!$url),
            EditAction::make(),
        ];
    }
}
