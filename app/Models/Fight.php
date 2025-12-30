<?php

namespace App\Models;

use App\Events\EndFight;
use Exception;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
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

    #[Scope]
    protected function current(Builder $query): void
    {
        $query->whereNotNull('started_at')->whereNull('ended_at');
    }

    public static function getCurrent(): ?Fight
    {
        $fight = Fight::query()->current()->first();
        $fight?->ensureVotesAreLoaded();
        return $fight;
    }

    public function ensureVotesAreLoaded()
    {
        foreach ([$this->leftTrack, $this->rightTrack] as $track) {
            if (!isset($track->votes_count)) {
                $track->loadCount('votes');
            }
        }
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
        $this->ensureVotesAreLoaded();
        $leftVotes = $this->leftTrack->votes_count;
        $rightVotes = $this->rightTrack->votes_count;
        if ($leftVotes === $rightVotes) {
            throw new Exception("No winner");
        }
        $winner = $leftVotes > $rightVotes ? 'left' : 'right';
        $this->leftTrack->update(['won' => $winner === 'left']);
        $this->rightTrack->update(['won' => $winner === 'right']);
        $this->update(['ended_at' => now()]);
        EndFight::dispatch($winner);
        return $this;
    }

    public function getWinnerAndLoser(): array
    {
        if (!$this->ended_at) {
            throw new Exception("Match is not ended");
        }
        if ($this->leftTrack->won) {
            return [$this->leftTrack, $this->rightTrack];
        } else if ($this->rightTrack->won) {
            return [$this->rightTrack, $this->leftTrack];
        }
        throw new Exception("No winner");
    }
}
