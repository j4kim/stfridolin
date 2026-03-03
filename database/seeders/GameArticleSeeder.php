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
            'meta' => ['qrcodes' => 2],
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'joes-weight')->firstOrFail()->id,
            'name' => "guess-joes-weight",
            'description' => "Pronostique sur le poids de Joe",
            'currency' => Currency::Tokens,
            'price' => 20,
            'meta' => ['participationLimit' => 10],
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'horse-show')->firstOrFail()->id,
            'name' => "bet-on-horse",
            'description' => "Pari sur un cheval",
            'currency' => Currency::Tokens,
            'price' => 30,
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'where-is-joe')->firstOrFail()->id,
            'name' => "where-is-joe",
            'description' => "Participation à \"Où est Joe ?\"",
            'currency' => Currency::Tokens,
            'price' => 30,
            'meta' => ['participationLimit' => 1],
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'where-is-joe')->firstOrFail()->id,
            'name' => "where-is-joe-bet",
            'description' => "Pari au \"Où est Joe ?\"",
            'currency' => Currency::Tokens,
            'price' => 0,
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'degustation')->firstOrFail()->id,
            'name' => "degustation",
            'description' => "Dégustation de vins de Troquet",
            'currency' => Currency::Tokens,
            'price' => 20,
            'meta' => ['qrcodes' => 2],
        ]);

        $domingold = Game::where('name', 'domingold')->firstOrFail();

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => $domingold->id,
            'name' => "domingold",
            'description' => "1 ticket de tombola",
            'currency' => Currency::Tokens,
            'price' => 12,
            'meta' => ['participationLimit' => 10, 'qrcodes' => 2],
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => $domingold->id,
            'name' => "domingold-5",
            'description' => "5 tickets de tombola",
            'currency' => Currency::Tokens,
            'price' => 50,
            'meta' => ['participationLimit' => 2, 'qrcodes' => 2],
        ]);

        $bullseye = Game::where('name', 'bullseye')->firstOrFail();

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => $bullseye->id,
            'name' => "bullseye",
            'description' => "Bullseye",
            'currency' => Currency::Tokens,
            'price' => 8,
            'meta' => ['qrcodes' => 2],
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => $bullseye->id,
            'name' => "bullseye-3",
            'description' => "Bullseye (3x)",
            'currency' => Currency::Tokens,
            'price' => 20,
            'meta' => ['qrcodes' => 2],
        ]);

        $ballToss = Game::where('name', 'ball-toss')->firstOrFail();

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => $ballToss->id,
            'name' => "ball-toss",
            'description' => "Lancer de balles",
            'currency' => Currency::Tokens,
            'price' => 8,
            'meta' => ['qrcodes' => 2],
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => $ballToss->id,
            'name' => "ball-toss-3",
            'description' => "Lancer de balles (3x)",
            'currency' => Currency::Tokens,
            'price' => 20,
            'meta' => ['qrcodes' => 2],
        ]);

        Article::create([
            'type' => ArticleType::Participation,
            'game_id' => Game::where('name', 'blind-donkey')->firstOrFail()->id,
            'name' => "blind-donkey",
            'description' => "L'âne aveugle",
            'currency' => Currency::Tokens,
            'price' => 8,
            'meta' => ['qrcodes' => 2],
        ]);
    }
}
