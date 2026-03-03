<?php

namespace Database\Seeders;

use App\Enums\CompetitorType;
use App\Enums\OccurrenceStatus;
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

        $marbleRace = Game::firstWhere('name', "marble-race");
        $tenCompetitors = Competitor::take(10)->pluck('id');
        foreach ($marbleRace->occurrences as $index => $occurrence) {
            $occurrence->competitors()->attach($tenCompetitors);
            if ($index === 0) {
                $occurrence->ranking = [5 => 1, 3 => 2, 8 => 3, 1 => 4, 10 => 5];
                $occurrence->status = OccurrenceStatus::Ranked;
                $occurrence->save();
            } else if ($index === 1) {
                $occurrence->status = OccurrenceStatus::Started;
                $occurrence->save();
            } else if ($index === 2) {
                $occurrence->status = OccurrenceStatus::Open;
                $occurrence->save();
            }
        }

        $horseShow = Game::firstWhere('name', "horse-show");
        $o = $horseShow->occurrences()->first();
        $competitors = collect();
        foreach ([1, 2, 3, 4] as $index) {
            $c = Competitor::create(['name' => "Équipe $index", 'type' => CompetitorType::Horse]);
            $competitors->push($c);
        }
        $o->competitors()->attach($competitors);

        $whereIsJoe = Game::firstWhere('name', "where-is-joe");
        $competitors = collect();
        for ($i = 1; $i < 10; $i++) {
            $c = Competitor::create([
                'name' => "Personnage #$i",
                'type' => CompetitorType::Character,
            ]);
            $competitors->push($c);
        }

        foreach ($whereIsJoe->occurrences as $occurrence) {
            $occurrence->competitors()->attach($competitors);
        }
    }
}
