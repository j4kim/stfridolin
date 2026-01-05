<?php

namespace App\Tools;

use App\Exceptions\NoSpotifyPlaybackException;
use App\Exceptions\NoSpotifyTokenException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
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

    public static function getTrack(string $spotifyUri): array
    {
        $id = explode(":", $spotifyUri)[2];
        return self::apiRequest()->get("tracks/$id")->throw()->json();
    }

    public static function searchTracks(string $q, int $offset = 0): array
    {
        return self::apiRequest()
            ->get('search', [
                'q' => $q,
                'type' => 'track',
                'market' => 'CH',
                'limit' => 10,
                'offset' => $offset,
            ])
            ->throw()
            ->json('tracks');
    }

    public static function devices(): Collection
    {
        $devices = self::apiRequest()->get('/me/player/devices')->throw()->collect('devices');
        return $devices->map(fn(array $device) => [
            ...$device,
            'selected' => $device['id'] === self::getSelectedDeviceId(),
        ]);
    }

    public static function getSelectedDeviceId(): ?string
    {
        return Cache::memo()->get('spotifySelectedDeviceId');
    }

    public static function selectDevice(string $deviceId)
    {
        self::apiRequest()->put("/me/player", ['device_ids' => [$deviceId]])->throw();
        Cache::put('spotifySelectedDeviceId', $deviceId);
    }

    public static function playTrack(string $trackUri): Response
    {
        return self::apiRequest()
            ->withQueryParameters(['device_id' => self::getSelectedDeviceId()])
            ->put("/me/player/play", ['position_ms' => 0, 'uris' => [$trackUri]]);
    }

    public static function skip(): Response
    {
        return self::apiRequest()
            ->withQueryParameters(['device_id' => self::getSelectedDeviceId()])
            ->post("/me/player/next");
    }

    public static function addToQueue(string $trackUri): Response
    {
        return self::apiRequest()
            ->withQueryParameters(['device_id' => self::getSelectedDeviceId(), 'uri' => $trackUri])
            ->post("/me/player/queue")
            ->throw();
    }
}
