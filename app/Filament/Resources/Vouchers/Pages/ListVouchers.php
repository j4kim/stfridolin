<?php

namespace App\Filament\Resources\Vouchers\Pages;

use App\Filament\Resources\Vouchers\VoucherResource;
use App\Models\Voucher;
use Database\Factories\VoucherFactory;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Model;

class ListVouchers extends ListRecords
{
    protected static string $resource = VoucherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Créer')
                ->schema([
                    Select::make('article_id')
                        ->relationship('article', 'description')
                        ->required(),
                    TextInput::make('quantity')
                        ->label("Quantité")
                        ->numeric()
                        ->required()
                        ->default(10),
                ])
                ->action(function (array $data) {
                    Voucher::factory($data['quantity'])->create(['article_id' => $data['article_id']]);
                    Notification::make()
                        ->title("$data[quantity] codes créés")
                        ->success()
                        ->send();
                })
                ->modalWidth(Width::Medium),
        ];
    }
}
