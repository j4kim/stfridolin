<?php

namespace Database\Seeders;

use App\Models\Track;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trackDir = __DIR__ . '/tracks';
        $trackFiles = collect(scandir($trackDir))->shuffle();
        foreach ($trackFiles as $filename) {
            $path = $trackDir . '/' . $filename;
            if (!is_file($path)) {
                continue;
            }
            $contents = file_get_contents($path);
            $json = json_decode($contents, true);
            Track::createFromSpotifyData($json);
        }
        Track::orderByDesc('id')->first()->update(['priority' => 1]);
    }
}
