<?php

namespace App\Tools;

class Translations
{
    public static function all(): array
    {
        return json_decode(
            file_get_contents(
                base_path('lang/fr.json')
            ),
            true
        );
    }
}
