<?php

namespace App\Models;

use App\Enums\GameType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'type' => GameType::class,
        ];
    }

    public function occurrences(): HasMany
    {
        return $this->hasMany(Occurrence::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
