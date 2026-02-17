<?php

namespace Database\Seeders;

use App\Enums\ArticleType;
use App\Enums\Currency;
use App\Models\Article;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PointsVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pointsCredits = [1, 2, 3, 5, 10, 20, 50, 100, 200, 500];

        foreach ($pointsCredits as $points) {
            $article = Article::create([
                'type' => ArticleType::PointsCredit,
                'name' => "$points-points",
                'description' => number_format($points, thousands_separator: '’') . " points",
                'currency' => Currency::None,
                'price' => 0,
                'meta' => ['points' => $points],
            ]);

            Voucher::factory(9)->create(['article_id' => $article->id]);
        }
    }
}
