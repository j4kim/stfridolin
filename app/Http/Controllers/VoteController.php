<?php

namespace App\Http\Controllers;

use App\Exceptions\FightEndedException;
use App\Models\Fight;
use App\Models\Guest;
use App\Models\Track;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote(Fight $fight, Track $track)
    {
        if ($fight->ended_at) {
            throw new FightEndedException;
        }
        $guest = Guest::fromRequest();
        $movement = $guest->vote($fight, $track);
        return [
            'message' => 'Vote enregistré',
            'movement' => $movement,
        ];
    }
}
