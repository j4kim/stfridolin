<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
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

    protected $hidden = ['spotify_data'];

    public function proposedBy(): BelongsTo
    {
        return $this->belongsTo(Guest::class, 'proposed_by');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public static function formatSpotifyData(array $data): array
    {
        return [
            'name' => $data['name'],
            'artist_name' => collect($data['artists'])->map(fn(array $a) => $a['name'])->join(', '),
            'spotify_uri' => $data['uri'],
            'img_url' => $data['album']['images'][0]['url'],
            'img_thumbnail_url' => $data['album']['images'][2]['url'],
        ];
    }

    public static function createFromSpotifyData(array $data, int $priority = 0)
    {
        return self::create([
            ...self::formatSpotifyData($data),
            'spotify_data' => $data,
            'priority' => $priority,
        ]);
    }

    #[Scope]
    protected function queue(Builder $query): void
    {
        $query->whereNull('used')->orderByDesc('priority')->orderBy('id');
    }

    public static function getCandidates(): Collection
    {
        return self::query()->queue()->take(2)->get();
    }

    public static function current(): Track
    {
        return Track::whereNull('played')->where('won', true)->first();
    }
}
