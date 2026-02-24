<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Competitor extends Model
{
    public function occurrences(): BelongsToMany
    {
        return $this->belongsToMany(Occurrence::class);
    }
}
