<?php

namespace Database\Seeders;

use App\Enums\GameType;
use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Game::create([
            'name' => "Jukeboxe",
            'type' => GameType::Jukeboxe,
        ]);
        Game::create([
            'name' => "Course de billes",
            'type' => GameType::Race,
        ])->occurrences()->createMany([
            [
                'title' => "Course de billes - 1ère manche",
                'start_at' => '2026-03-06 19:00:00',
                'end_at' => '2026-03-06 19:15:00',
            ],
            [
                'title' => "Course de billes - 2ème manche",
                'start_at' => '2026-03-06 20:00:00',
                'end_at' => '2026-03-06 20:15:00',
            ],
            [
                'title' => "Course de billes - 3ème manche",
                'start_at' => '2026-03-06 21:00:00',
                'end_at' => '2026-03-06 21:15:00',
            ],
            [
                'title' => "Course de billes - 4ème manche",
                'start_at' => '2026-03-06 22:00:00',
                'end_at' => '2026-03-06 22:15:00',
            ],
            [
                'title' => "Course de billes - Finale",
                'start_at' => '2026-03-06 23:00:00',
                'end_at' => '2026-03-06 23:15:00',
            ],
        ]);
        Game::create([
            'name' => "Quiz",
            'type' => GameType::Quiz,
        ])->occurrences()->createMany([
            [
                'title' => "Quiz - Saint-Fridolin",
                'start_at' => '2026-03-06 20:30:00',
                'end_at' => '2026-03-06 20:45:00',
            ],
            [
                'title' => "Quiz - Estelle Zamme",
                'start_at' => '2026-03-06 22:30:00',
                'end_at' => '2026-03-06 22:45:00',
            ],
        ]);
        Game::create([
            'name' => "Poids de Joe",
            'type' => GameType::Guess,
        ])->occurrences()->create(
            [
                'title' => "Poids de Joe",
                'start_at' => '2026-03-06 18:00:00',
                'end_at' => '2026-03-06 00:00:00',
            ],
        );
        Game::create([
            'name' => "Concours hippique",
            'type' => GameType::Race,
        ])->occurrences()->create(
            [
                'title' => "Concours hippique",
                'start_at' => '2026-03-06 23:30:00',
                'end_at' => '2026-03-06 23:45:00',
            ],
        );
        Game::create([
            'name' => "Où est Joe ?",
            'type' => GameType::Quiz,
        ])->occurrences()->createMany([
            [
                'title' => "Où est Joe ? - 1ère manche",
                'start_at' => '2026-03-06 21:30:00',
                'end_at' => '2026-03-06 21:35:00',
            ],
            [
                'title' => "Où est Joe ? - 2ème manche",
                'start_at' => '2026-03-06 21:35:00',
                'end_at' => '2026-03-06 22:40:00',
            ],
            [
                'title' => "Où est Joe ? - 3ème manche",
                'start_at' => '2026-03-06 22:40:00',
                'end_at' => '2026-03-06 22:45:00',
            ],
            [
                'title' => "Où est Joe ? - 4ème manche",
                'start_at' => '2026-03-06 22:45:00',
                'end_at' => '2026-03-06 22:50:00',
            ]
        ]);
        Game::create([
            'name' => "Dégustation",
            'type' => GameType::Fun,
        ])->occurrences()->create(
            [
                'title' => "Dégustation de Goron",
                'start_at' => '2026-03-06 19:15:00',
                'end_at' => '2026-03-06 22:00:00',
            ],
        );
        Game::create([
            'name' => "Domingold",
            'type' => GameType::Fun,
        ])->occurrences()->create(
            [
                'title' => "Domingold",
                'start_at' => '2026-03-06 18:00:00',
                'end_at' => '2026-03-06 00:00:00',
            ],
        );
        Game::create([
            'name' => "Bullseye",
            'type' => GameType::Fun,
        ]);
        Game::create([
            'name' => "Lance-balle",
            'type' => GameType::Fun,
        ]);
        Game::create([
            'name' => "L'âne aveugle",
            'type' => GameType::Fun,
        ]);
    }
}
