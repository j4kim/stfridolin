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
        ]);
        Game::create([
            'name' => "Quiz",
            'type' => GameType::Quiz,
        ]);
        Game::create([
            'name' => "Poids de Joe",
            'type' => GameType::Guess,
        ]);
        Game::create([
            'name' => "Concours hippique",
            'type' => GameType::Race,
        ]);
        Game::create([
            'name' => "Où est Joe ?",
            'type' => GameType::Quiz,
        ]);
        Game::create([
            'name' => "Dégustation",
            'type' => GameType::Fun,
        ]);
        Game::create([
            'name' => "Domingold",
            'type' => GameType::Fun,
        ]);
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
