<?php

namespace App\Filament\Resources\Guests\RelationManagers;

use App\Filament\Resources\Movements\MovementResource;
use App\Filament\Resources\Payments\PaymentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $relatedResource = PaymentResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([]);
    }

    public static function getTabComponent(Model $ownerRecord, string $pageClass): Tab
    {
        return Tab::make('Paiements')
            ->badge($ownerRecord->payments()->count())
            ->icon(Heroicon::CreditCard);
    }
}
