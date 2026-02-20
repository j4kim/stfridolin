<?php

namespace App\Filament\Resources\Sponsors\Pages;

use App\Filament\Resources\Sponsors\SponsorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSponsor extends CreateRecord
{
    use \App\Filament\Tools\RedirectsToViewPage;

    protected static string $resource = SponsorResource::class;
}
