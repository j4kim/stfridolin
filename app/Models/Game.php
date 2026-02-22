<?php

namespace App\Models;

use App\Enums\GameType;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'type' => GameType::class,
        ];
    }
}
