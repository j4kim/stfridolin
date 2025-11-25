<?php

namespace App\Http\Controllers;

use App\Tools\Spotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpotifyController extends Controller
{
    public function login(Request $request)
    {
        if ($request->intended) {
            session(['url.intended' => $request->intended]);
        }

        $url = Spotify::userAuthenticationUrl();

        return redirect()->away($url);
    }

    public function callback(Request $request)
    {
        if ($request->error) {
            abort(400, $request->error);
        } else if (!$request->code) {
            abort(500, "No code in request");
        }

        Spotify::requestAccessToken($request->code);

        return redirect()->intended('spotify-remote');
    }

    public function remote()
    {
        if (!session('spotifyToken')) {
            return redirect()->route('spotify-login');
        }

        $devices = Http::withToken(session('spotifyToken.access_token'))
            ->baseUrl('https://api.spotify.com/v1/')
            ->get('/me/player/devices')
            ->throw()
            ->json();

        dump($devices, session('spotifyToken'));
    }
}
