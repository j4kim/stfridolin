<?php

namespace App\Tools;

use App\Exceptions\NoSpotifyPlaybackException;
use App\Exceptions\NoSpotifyTokenException;
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

    public static function requestAccessToken(string $code): array
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

        return self::cacheToken($response);
    }

    public static function refreshToken(): array
    {
        $tokenInfo = Cache::get('spotifyTokenInfo');

        $client_id = config('services.spotify.client_id');
        $client_secret = config('services.spotify.client_secret');

        $response = Http::asForm()
            ->withBasicAuth($client_id, $client_secret)
            ->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $tokenInfo['refresh_token'],
            ])
            ->throw()
            ->json();

        $newTokenInfo = array_merge($tokenInfo, $response);

        return self::cacheToken($newTokenInfo);
    }

    public static function cacheToken(array $info): array
    {
        $tokenInfo = [
            'access_token' => $info['access_token'],
            'token_type' => $info['token_type'],
            'scope' => $info['scope'],
            'expires_in' => $info['expires_in'],
            'expires_at' => now()->addSeconds($info['expires_in']),
            'refresh_token' => $info['refresh_token'],
        ];
        Cache::put('spotifyTokenInfo', $tokenInfo);
        return $tokenInfo;
    }

    public static function getToken(): string
    {
        $tokenInfo = Cache::memo()->get('spotifyTokenInfo');
        if (!$tokenInfo) {
            throw new NoSpotifyTokenException;
        }
        $isExpired = now() > $tokenInfo['expires_at'];
        if ($isExpired) {
            $tokenInfo = self::refreshToken();
        }
        return $tokenInfo['access_token'];
    }

    public static function apiRequest(): PendingRequest
    {
        return Http::withToken(self::getToken())
            ->baseUrl('https://api.spotify.com/v1/');
    }

    public static function playbackState(): array
    {
        $response = Spotify::apiRequest()->get('/me/player')->throw();
        if ($response->status() === 204) {
            throw new NoSpotifyPlaybackException;
        }
        return $response->json();
    }

    public static function search(string $q, string $type = 'track', string $market = 'CH', int $limit = 10): Response
    {
        return self::apiRequest()
            ->get('search', compact('q', 'type', 'market', 'limit'))
            ->throw();
    }

    public static function searchTracks(string $q): array
    {
        return self::search($q, 'track')->json('tracks');
    }
}
