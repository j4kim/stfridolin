<?php

namespace App\Filament\Resources\Guests\Pages;

use App\Filament\Resources\Guests\GuestResource;
use Filament\Resources\Pages\EditRecord;

class EditGuest extends EditRecord
{
    use \App\Filament\Tools\RedirectsToViewPage;

    protected static string $resource = GuestResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
