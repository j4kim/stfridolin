<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Enums\PaymentMethod;
use App\Enums\PaymentPurpose;
use App\Enums\PaymentStatus;
use App\Filament\Resources\Payments\PaymentResource;
use App\Models\Payment;
use Filament\Actions\Action;
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
            Action::make('confirm')
                ->hidden(fn(Payment $payment) => $payment->method === PaymentMethod::Stripe)
                ->visible(fn(Payment $payment) => $payment->status !== PaymentStatus::succeeded)
                ->requiresConfirmation()
                ->action(fn(Payment $payment) => $payment->update(['status' => PaymentStatus::succeeded])),
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
