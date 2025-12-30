<?php

namespace App\Http\Controllers;

use App\Models\Fight;
use Exception;
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
        [$winner, $loser] = $fight?->end()->getWinnerAndLoser();
        return compact('fight', 'winner', 'loser');
    }

    public function createNext()
    {
        if (Fight::query()->current()->exists()) {
            throw new Exception("Current fight is not ended");
        }
        return Fight::createNext(true);
    }
}
