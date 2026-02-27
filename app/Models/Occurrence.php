<?php

namespace App\Models;

use App\Enums\MovementType;
use App\Enums\OccurrenceStatus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Occurrence extends Model
{
    use BroadcastsEvents;

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

    public function bets(): HasMany
    {
        return $this->movements()->where('type', MovementType::RaceBet);
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

    public function broadcastOn(string $event): array
    {
        return [new Channel("game-$this->game_id")];
    }
}
