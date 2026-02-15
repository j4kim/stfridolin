<?php

namespace App\Filament\Tools;

use function Filament\Support\get_model_label;

trait TranslateModelLabel
{
    public static function getModelLabel(): string
    {
        return __(get_model_label(static::getModel()));
    }
}
