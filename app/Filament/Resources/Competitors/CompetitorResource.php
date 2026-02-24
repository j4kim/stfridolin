<?php

namespace App\Filament\Resources\Competitors;

use App\Filament\Resources\Competitors\Pages\CreateCompetitor;
use App\Filament\Resources\Competitors\Pages\EditCompetitor;
use App\Filament\Resources\Competitors\Pages\ListCompetitors;
use App\Filament\Resources\Competitors\Pages\ViewCompetitor;
use App\Filament\Resources\Competitors\Schemas\CompetitorForm;
use App\Filament\Resources\Competitors\Schemas\CompetitorInfolist;
use App\Filament\Resources\Competitors\Tables\CompetitorsTable;
use App\Models\Competitor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompetitorResource extends Resource
{
    protected static ?string $model = Competitor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;
    protected static ?int $navigationSort = 820;
    protected static string | UnitEnum | null $navigationGroup = 'Gestion';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CompetitorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CompetitorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompetitorsTable::configure($table);
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
            'index' => ListCompetitors::route('/'),
            'create' => CreateCompetitor::route('/create'),
            'view' => ViewCompetitor::route('/{record}'),
            'edit' => EditCompetitor::route('/{record}/edit'),
        ];
    }
}
