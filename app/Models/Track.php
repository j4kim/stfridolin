<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Track extends Model
{
    protected function casts(): array
    {
        return [
            'spotify_data' => 'array',
        ];
    }

    public function proposedBy(): BelongsTo
    {
        return $this->belongsTo(Guest::class, 'proposed_by');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public static function createFromSpotifyData(array $data)
    {
        return self::create([
            'name' => $data['name'],
            'artist_name' => collect($data['artists'])->map(fn(array $a) => $a['name'])->join(', '),
            'spotify_uri' => $data['uri'],
            'img_url' => $data['album']['images'][0]['url'],
            'img_thumbnail_url' => $data['album']['images'][2]['url'],
            'spotify_data' => $data,
        ]);
    }

    public static function getCandidates(): Collection
    {
        return self::whereNull('won')
            ->orderByDesc('priority')
            ->orderBy('id')
            ->take(2)
            ->get();
    }

    public static function current(): Track
    {
        return Track::whereNull('played')->where('won', true)->first();
    }
}
