<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function store(Request $request)
    {
        return Track::createFromSpotifyData($request->all(), 1);
    }
}
