<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Tools\Spotify;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function store(string $spotifyUri)
    {
        $spotifyData = Spotify::getTrack($spotifyUri);
        return Track::createFromSpotifyData($spotifyData, 1);
    }
}
