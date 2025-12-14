<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

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
            Track::create(['spotify_data' => $json]);
        }
    }
}
