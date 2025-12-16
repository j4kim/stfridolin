<?php

namespace App\Http\Controllers;

use App\Models\Fight;
use Illuminate\Http\Request;

class FightController extends Controller
{
    public function current()
    {
        $fight = Fight::current()->load('leftTrack', 'rightTrack');
        $fight->leftTrack->loadCount('votes');
        $fight->rightTrack->loadCount('votes');
        return $fight;
    }
}
