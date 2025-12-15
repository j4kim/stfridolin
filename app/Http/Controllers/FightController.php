<?php

namespace App\Http\Controllers;

use App\Models\Fight;
use Illuminate\Http\Request;

class FightController extends Controller
{
    public function current()
    {
        return Fight::current()->load('leftTrack', 'rightTrack');
    }
}
