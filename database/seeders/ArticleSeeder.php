<?php

namespace Database\Seeders;

use App\Enums\ArticleType;
use App\Enums\Currency;
use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tokenPackages = [
            [
                'tokens' => 40,
                'discount' => 0, // 10 CHF
            ],
            [
                'tokens' => 100,
                'discount' => 0, // 25 CHF
            ],
            [
                'tokens' => 200,
                'discount' => 0.1, // 45 CHF instead of 50
            ],
            [
                'tokens' => 400,
                'discount' => 0.2, // 80 CHF instead of 100
            ],
            [
                'tokens' => 1000,
                'discount' => 0.4, // 150 CHF instead of 250
            ],
            [
                'tokens' => 100_000,
                'discount' => 0.98, // 500 CHF instead of 25k
            ],
        ];

        $tokenPrice = 0.25;

        foreach ($tokenPackages as $pkg) {
            $tokens = $pkg['tokens'];
            $discount = $pkg['discount'];
            $stdPrice = $tokens * $tokenPrice;
            $price = $stdPrice * (1 - $discount);
            Article::create([
                'type' => ArticleType::TokensPackage,
                'name' => "$tokens-tokens",
                'description' => number_format($tokens, thousands_separator: '’') . " jetons",
                'currency' => Currency::CHF,
                'std_price' => $stdPrice,
                'price' => $price,
                'meta' => ['tokens' => $tokens],
            ]);
        }

        Article::create([
            'type' => ArticleType::Registration,
            'name' => "registration",
            'description' => "Frais d'inscription",
            'currency' => Currency::CHF,
            'price' => 30,
            'meta' => ['tokens' => 20],
        ]);

        Article::create([
            'type' => ArticleType::Jukeboxe,
            'name' => "add-to-queue",
            'description' => "Ajout d'un morceau en file d'attente",
            'currency' => Currency::Tokens,
            'price' => 5,
        ]);

        Article::create([
            'type' => ArticleType::Jukeboxe,
            'name' => "vote",
            'description' => "Vote au Jukeboxe",
            'currency' => Currency::Tokens,
            'price' => 3,
        ]);
    }
}
