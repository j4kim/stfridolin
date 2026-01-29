<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\Track;
use App\Models\User;
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
        Guest::create([
            'name' => 'Joaquim',
            'key' => '0000',
            'tokens' => 100,
        ]);

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
