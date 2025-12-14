<?php

namespace Database\Seeders;

use App\Models\Fight;
use App\Models\Guest;
use App\Models\Track;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Guest::factory(10)->create();

        $trackDir = __DIR__ . '/tracks';
        $trackFiles = scandir($trackDir);
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

        $fight = Fight::createNext();
        $fight->start();
        Vote::create([
            'guest_id' => 1,
            'track_id' => $fight->leftTrack->id,
            'fight_id' => $fight->id,
        ]);
        $fight->end();
        Fight::createNext()->start();
    }
}
