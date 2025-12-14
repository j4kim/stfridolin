<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movement extends Model
{
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }
}
