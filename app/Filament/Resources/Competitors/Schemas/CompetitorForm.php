<?php

namespace App\Filament\Resources\Competitors\Schemas;

use App\Enums\CompetitorType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CompetitorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                FileUpload::make('image_path')
                    ->label("Logo")
                    ->disk('public')
                    ->directory('competitors')
                    ->visibility('public')
                    ->image()
                    ->imageEditor()
                    ->imageAspectRatio('1:1')
                    ->automaticallyOpenImageEditorForAspectRatio(),
                Select::make('type')->options(CompetitorType::class),
            ]);
    }
}
