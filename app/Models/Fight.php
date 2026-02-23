<?php

namespace App\Models;

use App\Events\EndFight;
use App\Events\NewFight;
use App\Exceptions\FightNotEndedException;
use App\Exceptions\NotEnoughTracksInQueueException;
use App\Exceptions\NoWinnerException;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fight extends Model
{
    public function leftTrack(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'left_track_id');
    }

    public function rightTrack(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'right_track_id');
    }

    public function wonTrack(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'won_track_id');
    }


    #[Scope]
    protected function current(Builder $query): void
    {
        $query->whereNotNull('started_at')->whereNull('ended_at');
    }

    public static function getCurrent(): ?Fight
    {
        /** @var Builder $query */
        $query = Fight::current();
        $fight = $query->first();
        $fight?->ensureVotesAreLoaded();
        return $fight;
    }

    public function loadVotes(): Fight
    {
        $this->leftTrack->loadCount(['votes' => function (Builder $query) {
            $query->where('fight_id', $this->id);
        }]);
        $this->rightTrack->loadCount(['votes' => function (Builder $query) {
            $query->where('fight_id', $this->id);
        }]);
        return $this;
    }

    public function ensureVotesAreLoaded(): Fight
    {
        if (!isset($this->leftTrack->votes_count)) {
            $this->loadVotes();
        }
        return $this;
    }

    public static function createNext(): Fight
    {
        $tracks = Track::getCandidates();
        if ($tracks->count() != 2) {
            throw new NotEnoughTracksInQueueException;
        }
        $fight = Fight::create([
            'left_track_id' => $tracks[0]->id,
            'right_track_id' => $tracks[1]->id,
            'started_at' => now(),
        ]);
        $tracks->each(fn(Track $t) => $t->update(['used' => true]));
        NewFight::dispatch($fight);
        return $fight;
    }

    public function end(): Fight
    {
        $this->ensureVotesAreLoaded();
        $leftVotes = $this->leftTrack->votes_count;
        $rightVotes = $this->rightTrack->votes_count;

        if ($leftVotes === $rightVotes) {
            $this->draw = true;
            $winner = collect(['left', 'right'])->random();
        } else {
            $winner = $leftVotes > $rightVotes ? 'left' : 'right';
        }
        $this->update(['won_track_id' => $winner === 'left' ? $this->leftTrack->id : $this->rightTrack->id]);
        $this->ended_at = now();
        $this->save();

        //Update priority on loser_track
        $loserTrack = $winner === 'left' ? $this->rightTrack : $this->leftTrack;
        $loserTrack->decrement('priority', 1, ['used' => false]);
        EndFight::dispatch($winner, $this->draw);
        return $this;
    }

    public function getWinner(): Track
    {
        if (!$this->ended_at) {
            throw new FightNotEndedException;
        }
        if ($this->leftTrack->id === $this->wonTrack->id) {
            return $this->leftTrack;
        } else if ($this->rightTrack->id === $this->wonTrack->id) {
            return $this->rightTrack;
        }
        throw new NoWinnerException;
    }

    public function addSponsorLogos(): Fight
    {
        $this->sponsor_logo_1 = Sponsor::getNext()?->logo_url;
        $this->sponsor_logo_2 = Sponsor::getNext()?->logo_url;
        return $this;
    }
}
