<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Enums\PaymentPurpose;
use App\Filament\Resources\Payments\PaymentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class ViewPayment extends ViewRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->schema([
                    Select::make('purpose')->options(PaymentPurpose::class),
                    TextInput::make('amount')->numeric(),
                    TextInput::make('description'),
                ])
                ->modalWidth(Width::Medium),
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        $record = $this->getRecord();
        return "Paiement #$record->id";
    }
}
