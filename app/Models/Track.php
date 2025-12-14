<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    public function proposedBy(): BelongsTo
    {
        return $this->belongsTo(Guest::class, 'proposed_by');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
