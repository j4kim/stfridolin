<?php

namespace App\Http\Controllers;

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
        [$winner, $loser] = $fight->getWinnerAndLoser();
        return compact('fight', 'winner', 'loser');
    }
}
