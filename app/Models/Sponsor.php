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
        static::saved(fn() => Cache::forget("sponsors"));
        static::deleted(fn() => Cache::forget("sponsors"));
    }

    protected $appends = ['logo_url'];

    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::url($this->logo_path),
        );
    }

    public static function cached(): Collection
    {
        return Cache::remember("sponsors", 60 * 60, fn() => Sponsor::all());
    }
}
