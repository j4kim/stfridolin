<?php

namespace App\Filament\Resources\Movements;

use App\Filament\Resources\Movements\Pages\ListMovements;
use App\Filament\Resources\Movements\Pages\ViewMovement;
use App\Filament\Resources\Movements\Schemas\MovementInfolist;
use App\Filament\Resources\Movements\Tables\MovementsTable;
use App\Models\Movement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MovementResource extends Resource
{
    use \App\Filament\Tools\TranslateModelLabel;

    protected static ?string $model = Movement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowsUpDown;
    protected static ?int $navigationSort = 400;
    protected static string | UnitEnum | null $navigationGroup = 'Gestion';

    protected static ?string $recordTitleAttribute = 'id';

    public static function infolist(Schema $schema): Schema
    {
        return MovementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MovementsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMovements::route('/'),
            'view' => ViewMovement::route('/{record}'),
        ];
    }
}
