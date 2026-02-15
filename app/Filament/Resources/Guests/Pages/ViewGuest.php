<?php

namespace App\Filament\Resources\Guests\Pages;

use App\Filament\Resources\Guests\GuestResource;
use App\Filament\Resources\Guests\RelationManagers\MovementsRelationManager;
use App\Filament\Resources\Guests\RelationManagers\PaymentsRelationManager;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewGuest extends ViewRecord
{
    protected static string $resource = GuestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function getRelationManagers(): array
    {
        return [
            MovementsRelationManager::class,
            PaymentsRelationManager::class,
        ];
    }

    public function getTitle(): string | Htmlable
    {
        $record = $this->getRecord();
        return $record->name;
    }
}
