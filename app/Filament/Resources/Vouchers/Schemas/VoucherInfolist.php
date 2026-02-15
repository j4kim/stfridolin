<?php

namespace App\Filament\Resources\Vouchers\Schemas;

use App\Filament\Tools\EntryTools;
use App\Models\Guest;
use App\Models\Voucher;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Livewire\Component;

class VoucherInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                EntryTools::systemSection(),

                EntryTools::compactSection()->schema([
                    EntryTools::guestLink()
                        ->belowLabel(function (?string $state) {
                            if ($state) return null;
                            return Action::make('Attacher')
                                ->schema([
                                    Select::make('guest_id')
                                        ->options(Guest::query()->get()->pluck('descriptor', 'id'))
                                        ->searchable()
                                        ->required()
                                ])
                                ->modalWidth(Width::Medium)
                                ->action(function (Voucher $voucher, array $data, Component $livewire) {
                                    $guest = Guest::find($data['guest_id']);
                                    $voucher->use($guest);
                                    return $livewire->redirect(request()->header('Referer'));
                                });
                        }),
                    EntryTools::articleLink(),
                ]),
            ]);
    }
}
