<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fight extends Model
{
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function leftTrack(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'left_track_id');
    }

    public function rightTrack(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'right_track_id');
    }
}
