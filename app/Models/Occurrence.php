<?php

namespace App\Models;

use App\Enums\OccurrenceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Occurrence extends Model
{
    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'status' => OccurrenceStatus::class,
        ];
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function competitors()
    {
        return $this->belongsToMany(Competitor::class);
    }
}
