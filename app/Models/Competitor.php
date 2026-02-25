<?php

namespace App\Models;

use App\Enums\CompetitorType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Competitor extends Model
{

    protected function casts(): array
    {
        return [
            'type' => CompetitorType::class,
        ];
    }

    protected $appends = ['image_url'];

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::url($this->image_path),
        );
    }

    public function occurrences(): BelongsToMany
    {
        return $this->belongsToMany(Occurrence::class);
    }
}
