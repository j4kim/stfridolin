<?php

namespace App\Models;

use App\Enums\MovementType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movement extends Model
{
    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'amount' => 'float',
            'type' => MovementType::class,
        ];
    }

    protected static function booted(): void
    {
        static::deleted(function (Movement $movement) {
            $guest = $movement->guest;
            $guest->recomputeTokensAndPoints()->save();
        });
    }


    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
