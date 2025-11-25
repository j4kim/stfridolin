<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpotifyController extends Controller
{
    public function login()
    {
        $url = url()->query('https://accounts.spotify.com/authorize', [
            'client_id' => config('services.spotify.client_id'),
            'response_type' => 'code',
            'redirect_uri' => 'http://127.0.0.1:8000/spotify-callback',
            'state' => str()->random(),
            'scope' => implode(' ', [
                'streaming user-read-email',
                'user-read-private',
                'user-modify-playback-state',
                'user-read-playback-state',
                'user-read-currently-playing'
            ]),
        ]);
        return redirect()->away($url);
    }

    public function callback(Request $request)
    {
        if ($request->error) {
            abort(400, $request->error);
        } else if (!$request->code) {
            abort(500, "No code in request");
        }

        $client_id = config('services.spotify.client_id');
        $client_secret = config('services.spotify.client_secret');

        $response = Http::asForm()
            ->withBasicAuth($client_id, $client_secret)
            ->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'authorization_code',
                'code' => $request->code,
                'redirect_uri' => 'http://127.0.0.1:8000/spotify-callback',
            ])
            ->throw()
            ->json();

        session(['spotifyToken' => $response]);

        return "Successfully connected to Spotify";
    }
}
