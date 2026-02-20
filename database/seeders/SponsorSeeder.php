<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sponsor::create([
            "name" => "La Semeuse",
            "logo_path" => "sponsors/lasemeuse.svg",
        ]);
        Sponsor::create([
            "name" => "Coyote",
            "logo_path" => "sponsors/coyote.png",
        ]);
    }
}
