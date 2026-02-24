<?php

namespace App\Filament\Resources\Competitors\Pages;

use App\Filament\Resources\Competitors\CompetitorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCompetitor extends EditRecord
{
    use \App\Filament\Tools\RedirectsToViewPage;

    protected static string $resource = CompetitorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
