<?php

namespace App\Filament\Resources\Occurrences\Pages;

use App\Filament\Resources\Occurrences\OccurrenceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOccurrence extends EditRecord
{
    use \App\Filament\Tools\RedirectsToViewPage;

    protected static string $resource = OccurrenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
