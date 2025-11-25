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
        return Spotify::apiRequest()->get('/me/player/devices')->throw()->json();
    }

    public function playbackState()
    {
        return Spotify::playbackState();
    }

    public function play()
    {
        return Spotify::apiRequest()
            ->put("/me/player/play", ['position_ms' => 0])
            ->throw();
    }

    public function pause()
    {
        return Spotify::apiRequest()
            ->put("/me/player/pause")
            ->throw();
    }
}
