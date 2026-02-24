<?php

namespace App\Filament\Resources\Competitors\Schemas;

use Filament\Forms\Components\FileUpload;
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
            ]);
    }
}
