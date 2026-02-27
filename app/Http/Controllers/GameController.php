<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function get(string $gameName)
    {
        return Game::with(['occurrences', 'articles'])->firstWhere('name', $gameName);
    }
}
