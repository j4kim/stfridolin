<?php

namespace App\Filament\Resources\Vouchers\Schemas;

use App\Filament\Tools\EntryTools;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VoucherInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                EntryTools::systemSection(),

                EntryTools::compactSection()->schema([
                    EntryTools::guestLink(),
                    EntryTools::articleLink(),
                ]),
            ]);
    }
}
