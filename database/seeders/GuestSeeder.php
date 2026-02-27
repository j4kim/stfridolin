<?php

namespace Database\Seeders;

use App\Enums\MovementType;
use App\Models\Guest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guest::create([
            'name' => 'Alice',
            'key' => 'aaaa',
        ])->createMovement([
            'type' => MovementType::Manual,
            'tokens' => 10_000,
        ]);
        Guest::create([
            'name' => 'Bob',
            'key' => 'bbbb',
        ])->createMovement([
            'type' => MovementType::Manual,
            'tokens' => 100,
            'points' => 1000,
        ]);;
        Guest::create([
            'name' => 'Charlie',
            'key' => 'cccc',
        ]);
    }
}
