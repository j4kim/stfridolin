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
            "logo_url" => "https://www.lasemeuse.ch/static/version1770816718/frontend/Mgs/lasemeuse/fr_FR/images/logo.svg",
        ]);
        Sponsor::create([
            "name" => "Christen Delicatessen",
            "logo_url" => "https://christen-delicatessen.ch/wp-content/uploads/2021/05/logo_blanc.svg",
        ]);
        Sponsor::create([
            "name" => "Coyote",
            "logo_url" => asset("logos/coyote.png"),
        ]);
    }
}
