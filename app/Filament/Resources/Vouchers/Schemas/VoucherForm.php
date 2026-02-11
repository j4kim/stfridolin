<?php

namespace App\Filament\Resources\Vouchers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class VoucherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('article_id')
                    ->relationship('article', 'description')
                    ->required(),
            ]);
    }
}
