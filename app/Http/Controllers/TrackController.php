<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Track;
use App\Tools\Spotify;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function store(string $spotifyUri)
    {
        $guest = Guest::fromRequest();
        $spotifyData = Spotify::getTrack($spotifyUri);
        $track = Track::createFromSpotifyData($spotifyData, config('jukeboxe.priorities.guest_added'));
        $movement = $guest->addTrack($track);
        return $track;
    }

    public function queue()
    {
        return Track::queryQueue()->with('proposedBy:id,name')->get();
    }
}
