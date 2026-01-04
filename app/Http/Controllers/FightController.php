<?php

namespace App\Http\Controllers;

use App\Exceptions\FightNotEndedException;
use App\Exceptions\NoCurrentFightException;
use App\Exceptions\NoWinnerException;
use App\Models\Fight;
use Illuminate\Http\Request;

class FightController extends Controller
{
    public function current()
    {
        $fight = Fight::getCurrent();
        return $fight;
    }

    public function end(Request $request)
    {
        $fight = Fight::getCurrent();
        if (!$fight) {
            throw new NoCurrentFightException;
        }
        try {
            $fight->end(!!$request->toss);
        } catch (NoWinnerException $e) {
            if ($request->silent) {
                return ['error' => get_class($e)];
            }
            throw $e;
        }
        [$winner, $loser] = $fight->getWinnerAndLoser();
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
