<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Sponsor extends Model
{
    protected static function booted(): void
    {
        static::saved(fn() => self::clearCache());
        static::deleted(fn() => self::clearCache());
    }

    protected $appends = ['logo_url'];

    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::url($this->logo_path),
        );
    }

    public static function clearCache()
    {
        Cache::forget("sponsors");
        Cache::forget("sponsor-index");
    }

    public static function cached(): Collection
    {
        return Cache::memo()->rememberForever("sponsors", fn() => Sponsor::all());
    }

    public static function getNext(): Sponsor
    {
        $sponsors = self::cached();
        $count = $sponsors->count();
        $index = Cache::rememberForever("sponsor-index", fn() => rand(0, $count - 1));
        $sponsor = $sponsors->get($index % $count);
        Cache::increment("sponsor-index");
        return $sponsor;
    }
}
