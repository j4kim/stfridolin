<?php

namespace App\Models;

use App\Enums\OccurrenceStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Occurrence extends Model
{
    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'ranking' => 'array',
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'status' => OccurrenceStatus::class,
        ];
    }

    protected $appends = ['start_at_time', 'bets_open_at_time'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function competitors(): BelongsToMany
    {
        return $this->belongsToMany(Competitor::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }

    protected function startAtTime(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->start_at?->format('H:i'),
        );
    }

    protected function betsOpenAtTime(): Attribute
    {
        return Attribute::make(
            get: function () {
                /** @var Carbon|null $startAt */
                $startAt = $this->start_at;
                if ($startAt) {
                    return $startAt->clone()->subMinutes(30)->format('H:i');
                }
                return null;
            },
        );
    }
}
