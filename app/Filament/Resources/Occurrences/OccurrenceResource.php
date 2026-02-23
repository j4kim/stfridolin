<?php

namespace App\Filament\Resources\Occurrences;

use App\Filament\Resources\Occurrences\Pages\CreateOccurrence;
use App\Filament\Resources\Occurrences\Pages\EditOccurrence;
use App\Filament\Resources\Occurrences\Pages\ListOccurrences;
use App\Filament\Resources\Occurrences\Pages\ViewOccurrence;
use App\Filament\Resources\Occurrences\Schemas\OccurrenceForm;
use App\Filament\Resources\Occurrences\Schemas\OccurrenceInfolist;
use App\Filament\Resources\Occurrences\Tables\OccurrencesTable;
use App\Models\Occurrence;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class OccurrenceResource extends Resource
{
    protected static ?string $modelLabel = 'occurrence';

    protected static ?string $model = Occurrence::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFlag;
    protected static ?int $navigationSort = 810;
    protected static string | UnitEnum | null $navigationGroup = 'Gestion';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return OccurrenceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OccurrenceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OccurrencesTable::configure($table);
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
            'index' => ListOccurrences::route('/'),
            'create' => CreateOccurrence::route('/create'),
            'view' => ViewOccurrence::route('/{record}'),
            'edit' => EditOccurrence::route('/{record}/edit'),
        ];
    }
}
