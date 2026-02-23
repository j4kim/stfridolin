<?php

namespace Database\Seeders;

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
        ]);
        Guest::create([
            'name' => 'Bob',
            'key' => 'bbbb',
        ]);
        Guest::create([
            'name' => 'Charlie',
            'key' => 'cccc',
        ]);
    }
}
