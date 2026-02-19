<?php

namespace App\Filament\Tools;

trait RedirectsToViewPage
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
