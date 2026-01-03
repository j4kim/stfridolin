<?php

namespace App\Http\Controllers;

use App\Exceptions\FightNotEndedException;
use App\Exceptions\NoCurrentFightException;
use App\Models\Fight;
use Illuminate\Http\Request;

class FightController extends Controller
{
    public function current()
    {
        $fight = Fight::getCurrent();
        return $fight;
    }

    public function end()
    {
        $fight = Fight::getCurrent();
        if (!$fight) {
            throw new NoCurrentFightException;
        }
        [$winner, $loser] = $fight->end()->getWinnerAndLoser();
        return compact('fight', 'winner', 'loser');
    }

    public function createNext()
    {
        if (Fight::query()->current()->exists()) {
            throw new FightNotEndedException;
        }
        return Fight::createNext();
    }
}
