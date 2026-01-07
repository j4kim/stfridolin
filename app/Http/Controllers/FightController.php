<?php

namespace App\Http\Controllers;

use App\Exceptions\FightEndedException;
use App\Exceptions\FightNotEndedException;
use App\Exceptions\NoCurrentFightException;
use App\Models\Fight;
use App\Tools\Spotify;
use Illuminate\Http\Request;

use function Illuminate\Support\defer;

class FightController extends Controller
{
    public function current()
    {
        $fight = Fight::getCurrent();
        if (!$fight) {
            throw new NoCurrentFightException;
        }
        return $fight;
    }

    public function end(Fight $fight)
    {
        if ($fight->ended_at) {
            throw new FightEndedException;
        }
        $winner = $fight->end()->getWinner();
        defer(fn() => Spotify::addToQueue($winner->spotify_uri));
        return $fight;
    }

    public function createFirst()
    {
        return Fight::createNext();
    }

    public function createNext(Fight $fight)
    {
        if (!$fight->ended_at) {
            throw new FightNotEndedException;
        }
        return Fight::createNext();
    }
}
