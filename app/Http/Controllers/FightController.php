<?php

namespace App\Http\Controllers;

use App\Exceptions\FightEndedException;
use App\Exceptions\FightNotEndedException;
use App\Models\Fight;
use App\Tools\Spotify;
use Illuminate\Http\Request;

class FightController extends Controller
{
    public function current()
    {
        $fight = Fight::getCurrent();
        return $fight;
    }

    public function end(Fight $fight)
    {
        if ($fight->ended_at) {
            throw new FightEndedException;
        }
        [$winner, $loser] = $fight->end()->getWinnerAndLoser();
        Spotify::addToQueue($winner->uri); // todo: defer after response is sent
        return $fight;
    }

    public function createNext(Fight $fight)
    {
        if (!$fight->ended_at) {
            throw new FightNotEndedException;
        }
        return Fight::createNext();
    }
}
