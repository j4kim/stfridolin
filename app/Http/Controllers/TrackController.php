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
        $movement = $guest->spendTokens('add-to-queue');
        $spotifyData = Spotify::getTrack($spotifyUri);

        $track = Track::create([
            ...Track::formatSpotifyData($spotifyData),
            'spotify_data' => $spotifyData,
            'priority' => TRACK_PRIORITY_GUEST_ADDED,
            'proposed_by' => $guest ? $guest->id : null,
        ]);

        $movement->update(['meta->track_id' => $track->id]);
        return $track;
    }

    public function queue()
    {
        return Track::query()->queue()->get();
    }
}
