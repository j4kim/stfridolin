<?php

namespace App\Tools;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Spotify
{
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
