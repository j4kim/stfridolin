<?php

namespace App\Http\Controllers;

use App\Exceptions\FightEndedException;
use App\Models\Fight;
use App\Models\Guest;
use App\Models\Track;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote(Fight $fight, Track $track)
    {
        if ($fight->ended_at) {
            throw new FightEndedException;
        }
        $guest = Guest::fromRequest();
        $movement = $guest->spendTokens('vote');
        $vote = Vote::create([
            'guest_id' => $guest->id,
            'track_id' => $track->id,
            'fight_id' => $fight->id,
        ]);
        $movement->update(['meta->vote_id' => $vote->id]);
    }
}
