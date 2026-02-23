<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class);
    }

    public function competitors()
    {
        return $this->belongsToMany(Competitor::class);
    }
}
