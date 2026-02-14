<?php

namespace App\Filament\Tools;

use Closure;

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
}
