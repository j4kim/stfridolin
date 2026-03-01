<?php

namespace Database\Seeders;

use App\Enums\ArticleType;
use App\Enums\Currency;
use App\Models\Article;
use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::where('type', 'jukeboxe')->delete();

        $jukeboxe = Game::where('name', 'jukeboxe')->firstOrFail();

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => $jukeboxe->id,
            'name' => "add-to-queue",
            'description' => "Ajout d'un morceau en file d'attente",
            'currency' => Currency::Tokens,
            'price' => 5,
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => $jukeboxe->id,
            'name' => "vote",
            'description' => "Vote au Jukeboxe",
            'currency' => Currency::Tokens,
            'price' => 3,
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'marble-race')->firstOrFail()->id,
            'name' => "bet-on-a-marble",
            'description' => "Pari sur une bille",
            'currency' => Currency::Tokens,
            'price' => 20,
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'quiz')->firstOrFail()->id,
            'name' => "participate-to-quiz",
            'description' => "Participation au quiz",
            'currency' => Currency::Tokens,
            'price' => 20,
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'joes-weight')->firstOrFail()->id,
            'name' => "guess-joes-weight",
            'description' => "Pronostique sur le poids de Joe",
            'currency' => Currency::Tokens,
            'price' => 20,
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'horse-show')->firstOrFail()->id,
            'name' => "bet-on-horse",
            'description' => "Pari sur un cheval",
            'currency' => Currency::Tokens,
            'price' => 20,
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'where-is-joe')->firstOrFail()->id,
            'name' => "where-is-joe",
            'description' => "Participation à \"Où est Joe ?\"",
            'currency' => Currency::Tokens,
            'price' => 20,
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'degustation')->firstOrFail()->id,
            'name' => "degustation",
            'description' => "Participation à la dégustation",
            'currency' => Currency::Tokens,
            'price' => 20,
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'domingold')->firstOrFail()->id,
            'name' => "domingold",
            'description' => "Participation à la tombola",
            'currency' => Currency::Tokens,
            'price' => 20,
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'bullseye')->firstOrFail()->id,
            'name' => "bullseye",
            'description' => "Participation au bullseye",
            'currency' => Currency::Tokens,
            'price' => 8,
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'ball-toss')->firstOrFail()->id,
            'name' => "ball-toss",
            'description' => "Participation au lancer de balles",
            'currency' => Currency::Tokens,
            'price' => 8,
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'blind-donkey')->firstOrFail()->id,
            'name' => "blind-donkey",
            'description' => "Participation à l'âne aveugle",
            'currency' => Currency::Tokens,
            'price' => 8,
        ]);
    }
}
