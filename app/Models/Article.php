<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected function casts(): array
    {
        return [
            'meta' => 'array',
        ];
    }
}
