<?php

namespace App\Models;

use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use BroadcastsEvents;

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    public function fight(): BelongsTo
    {
        return $this->belongsTo(Fight::class);
    }

    public function broadcastOn(string $event): array
    {
        return [new Channel('votes')];
    }
}
