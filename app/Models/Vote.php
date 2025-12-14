<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    public function fight(): BelongsTo
    {
        return $this->belongsTo(Fight::class);
    }
}
