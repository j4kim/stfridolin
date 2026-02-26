<?php

namespace App\Models;

use App\Enums\MovementType;
use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movement extends Model
{
    use BroadcastsEvents;

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

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function occurrence(): BelongsTo
    {
        return $this->belongsTo(Occurrence::class);
    }

    public function competitor(): BelongsTo
    {
        return $this->belongsTo(Competitor::class);
    }

    public function fight(): BelongsTo
    {
        return $this->belongsTo(Fight::class);
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    public function broadcastOn(string $event): array
    {
        $channels = [];
        if ($this->type === MovementType::JukeboxeVote) {
            $channels[] = new Channel("votes");
        }
        return $channels;
    }
}
