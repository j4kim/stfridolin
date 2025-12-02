<?php

namespace App\Http\Controllers;

use App\Tools\Spotify;
use Illuminate\Http\Request;

class SpotifyController extends Controller
{
    public function login(Request $request)
    {
        if ($request->intended) {
            session(['url.intended' => $request->intended]);
        }

        return redirect()->away(Spotify::userAuthenticationUrl());
    }

    public function callback(Request $request)
    {
        if ($request->error) {
            abort(400, $request->error);
        } else if (!$request->code) {
            abort(500, "No code in request");
        }

        Spotify::requestAccessToken($request->code);

        return redirect()->intended('spotify-devices');
    }

    public function devices()
    {
        return Spotify::devices();
    }

    public function playbackState()
    {
        return Spotify::playbackState();
    }

    public function play(Request $request)
    {
        $spotifyRequest = Spotify::apiRequest();
        if ($request->device_id) {
            $spotifyRequest->withQueryParameters(['device_id' => $request->device_id]);
        }
        return $spotifyRequest->put("/me/player/play", ['position_ms' => 0]);
    }

    public function pause()
    {
        return Spotify::apiRequest()
            ->put("/me/player/pause")
            ->throw();
    }

    public function selectDevice(string $deviceId)
    {
        Spotify::selectDevice($deviceId);
    }

    public function searchTracks(Request $request)
    {
        if (!$request->q) {
            return ['items' => []];
        }
        return Spotify::searchTracks($request->q);
    }
}
