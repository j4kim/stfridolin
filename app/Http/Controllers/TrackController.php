<?php

namespace App\Http\Controllers;

use App\Exceptions\ClosedJukeboxException;
use App\Models\Game;
use App\Models\Guest;
use App\Models\Track;
use App\Tools\Spotify;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function store(string $spotifyUri)
    {
        if (Game::where('name', '=', 'jukeboxe')->first()->active == false) {
            throw new ClosedJukeboxException();
        }
        $guest = Guest::fromRequest();
        $spotifyData = Spotify::getTrack($spotifyUri);
        $track = Track::createFromSpotifyData($spotifyData, config('jukeboxe.priorities.guest_added'));
        $movement = $guest->addTrack($track);
        return [
            'track' => $track,
            'movement' => $movement,
            'message' => "Morceau ajouté à la file d'attente",
        ];
    }

    public function queue()
    {
        return Track::queryQueue()->get();
    }
}
