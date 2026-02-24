<?php

namespace Database\Seeders;

use App\Models\Competitor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompetitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            "Vent d’Éclair",
            "Ombre Royale",
            "Rivière de Feu",
            "Tonnerre d’Argent",
            "Pirate Fantôme",
            "Turbo Pépère",
            "Triple Espoir",
            "Surprise du Chef",
            "Cristal de Lune",
            "Grand Kevin",
            "Biboule de Feu",
            "Foudre de la Nuit",
            "Sapin de Noël",
        ];

        foreach ($names as $name) {
            Competitor::create([
                'name' => $name,
            ]);
        }
    }
}
