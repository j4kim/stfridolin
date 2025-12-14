<?php

namespace App\Models;

use Exception;
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

    public static function createNext(): Fight
    {
        $tracks = Track::getCandidates();
        if ($tracks->count() != 2) {
            throw new Exception("There are no 2 candidates");
        }
        return Fight::create([
            'left_track_id' => $tracks[0]->id,
            'right_track_id' => $tracks[1]->id,
        ]);
    }

    public function start(): Fight
    {
        $this->started_at = now();
        $this->save();
        return $this;
    }

    public function end(): Fight
    {
        $leftVotes = $this->leftTrack->votes()->count();
        $rightVotes = $this->rightTrack->votes()->count();
        if ($leftVotes === $rightVotes) {
            throw new Exception("No winner");
        }
        $this->leftTrack->update(['won' => $leftVotes > $rightVotes]);
        $this->rightTrack->update(['won' => $rightVotes > $leftVotes]);
        $this->update(['ended_at' => now()]);
        return $this;
    }
}
