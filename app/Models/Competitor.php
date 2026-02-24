<?php

namespace App\Models;

use App\Enums\CompetitorType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Competitor extends Model
{

    protected function casts(): array
    {
        return [
            'type' => CompetitorType::class,
        ];
    }

    public function occurrences(): BelongsToMany
    {
        return $this->belongsToMany(Occurrence::class);
    }
}
