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
            'name' => "jukeboxe",
            'type' => GameType::Jukeboxe,
            'title' =>  "Jukeboxe",
        ]);
        Game::create([
            'name' => "marble-race",
            'type' => GameType::Race,
            'title' =>  "Course de billes",
        ])->occurrences()->createMany([
            [
                'title' => "1ère manche",
                'start_at' => '2026-03-06 19:00:00',
                'end_at' => '2026-03-06 19:15:00',
                'meta' => ['points' => 2000]
            ],
            [
                'title' => "2ème manche",
                'start_at' => '2026-03-06 20:00:00',
                'end_at' => '2026-03-06 20:15:00',
                'meta' => ['points' => 2000]
            ],
            [
                'title' => "3ème manche",
                'start_at' => '2026-03-06 21:00:00',
                'end_at' => '2026-03-06 21:15:00',
                'meta' => ['points' => 2000]
            ],
            [
                'title' => "4ème manche",
                'start_at' => '2026-03-06 22:00:00',
                'end_at' => '2026-03-06 22:15:00',
                'meta' => ['points' => 2000]
            ],
            [
                'title' => "Finale",
                'start_at' => '2026-03-06 23:00:00',
                'end_at' => '2026-03-06 23:15:00',
                'meta' => ['points' => 2000]
            ],
        ]);
        Game::create([
            'name' => "quiz",
            'type' => GameType::Quiz,
            'title' =>  "Quiz",
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
            'name' => "joes-weight",
            'type' => GameType::Guess,
            'title' =>  "Poids de Joe",
        ])->occurrences()->create(
            [
                'title' => "Poids de Joe",
                'start_at' => '2026-03-06 18:00:00',
                'end_at' => '2026-03-06 00:00:00',
                'meta' => ['weighing' => null],
            ],
        );
        Game::create([
            'name' => "horse-show",
            'type' => GameType::Race,
            'title' =>  "Concours hippique",
        ])->occurrences()->create(
            [
                'title' => "Manche unique",
                'start_at' => '2026-03-06 23:30:00',
                'end_at' => '2026-03-06 23:45:00',
                'meta' => ['points' => 10000]
            ],
        );
        Game::create([
            'name' => "where-is-joe",
            'type' => GameType::Quiz,
            'title' =>  "Où est Joe ?",
        ])->occurrences()->createMany([
            [
                'title' => "1ère manche",
                'start_at' => '2026-03-06 22:30:00',
                'end_at' => '2026-03-06 22:33:00',
                'meta' => ['points' => 2000],
            ],
            [
                'title' => "2ème manche",
                'start_at' => '2026-03-06 22:33:00',
                'end_at' => '2026-03-06 22:36:00',
                'meta' => ['points' => 2000],
            ],
            [
                'title' => "3ème manche",
                'start_at' => '2026-03-06 22:36:00',
                'end_at' => '2026-03-06 22:39:00',
                'meta' => ['points' => 2000],
            ],
            [
                'title' => "4ème manche",
                'start_at' => '2026-03-06 22:39:00',
                'end_at' => '2026-03-06 22:42:00',
                'meta' => ['points' => 2000],
            ],
            [
                'title' => "5ème manche",
                'start_at' => '2026-03-06 22:42:00',
                'end_at' => '2026-03-06 22:45:00',
                'meta' => ['points' => 2000],
            ],
            [
                'title' => "6ème manche",
                'start_at' => '2026-03-06 22:45:00',
                'end_at' => '2026-03-06 22:48:00',
                'meta' => ['points' => 2000],
            ],
        ]);
        Game::create([
            'name' => "degustation",
            'type' => GameType::Fun,
            'title' =>  "Dégustation",
        ])->occurrences()->create(
            [
                'title' => "Dégustation de Goron",
                'start_at' => '2026-03-06 19:15:00',
                'end_at' => '2026-03-06 22:00:00',
            ],
        );
        Game::create([
            'name' => "domingold",
            'type' => GameType::Fun,
            'title' =>  "Domingold",
        ])->occurrences()->create(
            [
                'title' => "Domingold",
                'start_at' => '2026-03-06 18:00:00',
                'end_at' => '2026-03-06 00:00:00',
            ],
        );
        Game::create([
            'name' => "bullseye",
            'type' => GameType::Fun,
            'title' =>  "Bullseye",
        ]);
        Game::create([
            'name' => "ball-toss",
            'type' => GameType::Fun,
            'title' =>  "Lance-balle",
        ]);
        Game::create([
            'name' => "blind-donkey",
            'type' => GameType::Fun,
            'title' =>  "L'âne aveugle",
        ]);
    }
}
