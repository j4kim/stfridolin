<?php

namespace Database\Seeders;

use App\Enums\CompetitorType;
use App\Models\Competitor;
use App\Models\Game;
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

        foreach ($names as $index => $name) {
            $i = ($index % 9) + 1;
            Competitor::create([
                'name' => $name,
                'image_path' => "competitors/marble - $i.jpeg",
                'type' => CompetitorType::Marble,
            ]);
        }

        $game = Game::firstWhere('name', "marble-race");
        $tenCompetitors = Competitor::take(10)->pluck('id');
        foreach ($game->occurrences as $occurrence) {
            $occurrence->competitors()->attach($tenCompetitors);
        }
    }
}
