<?php

namespace App\Tools;

class Version
{
    public static function get(): string
    {
        return json_decode(
            file_get_contents(
                base_path('package.json')
            ),
            true
        )['version'];
    }
}
