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


    public function frontEndUrl(?int $occurrenceId): ?string
    {
        return match ($this->name) {
            "jukeboxe" => route('vue-app', "boxing"),
            "marble-race" => route('vue-app', "race/marble-race/$occurrenceId"),
            "quiz" => null,
            "joes-weight" => route('vue-app', "joes-weight"),
            "horse-show" => route('vue-app', "race/horse-show/$occurrenceId"),
            "where-is-joe" => null,
            "degustation" => null,
            "domingold" => null,
            "bullseye" => null,
            "ball-toss" => null,
            "blind-donkey" => null,
        };
    }
}
