<?php

namespace App\Tools;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Spotify
{
    public static function userAuthenticationUrl(): string
    {
        return url()->query('https://accounts.spotify.com/authorize', [
            'client_id' => config('services.spotify.client_id'),
            'response_type' => 'code',
            'redirect_uri' => config('services.spotify.redirect_uri'),
            'state' => str()->random(),
            'scope' => config('services.spotify.scope'),
        ]);
    }

    public static function requestAccessToken(string $code): bool
    {
        $client_id = config('services.spotify.client_id');
        $client_secret = config('services.spotify.client_secret');

        $response = Http::asForm()
            ->withBasicAuth($client_id, $client_secret)
            ->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => config('services.spotify.redirect_uri'),
            ])
            ->throw()
            ->json();

        session(['spotifyToken' => [
            'access_token' => $response->access_token,
            'token_type' => $response->token_type,
            'scope' => $response->scope,
            'expires_in' => $response->expires_in,
            'expires_at' => now()->addSeconds($response->expires_in),
            'refresh_token' => $response->refresh_token,
        ]]);

        return true;
    }

    public function requestToken(): string
    {
        return Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
            'client_id' => config('services.spotify.client_id'),
            'client_secret' => config('services.spotify.client_secret'),
        ])->throw()->json('access_token');
    }

    public function getCachedToken(): string
    {
        return Cache::memo()->remember('spotify-token', 3500, fn() => $this->requestToken());
    }

    public function api(): PendingRequest
    {
        return Http::withToken($this->getCachedToken())
            ->baseUrl('https://api.spotify.com/v1/');
    }

    public function search(string $q, string $type = 'track', string $market = 'CH', int $limit = 10): Response
    {
        return $this->api()
            ->get('search', compact('q', 'type', 'market', 'limit'))
            ->throw();
    }

    public function searchTracks(string $q): array
    {
        return $this->search($q, 'track')->json('tracks');
    }
}
