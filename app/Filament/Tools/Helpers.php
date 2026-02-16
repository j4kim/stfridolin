<?php

namespace App\Filament\Tools;

use Closure;
use Filament\Support\Colors\Color;
use Filament\Support\Components\Component;

class Helpers
{
    public static function signedFormatter(): Closure
    {
        return function ($state): string {
            if ($state > 0) {
                return "+$state";
            }
            return $state;
        };
    }

    public static function discountColor(): Closure
    {
        return function ($state) {
            if (!$state) {
                return null;
            }
            if ($state > 50) {
                return Color::Fuchsia;
            }
            return Color::Sky;
        };
    }

    public static function setLabel(Component $component): void
    {
        $name = $component->getName();
        $tr = __($name);
        if ($tr != $name) {
            $component->label($tr);
        }
    }
}
