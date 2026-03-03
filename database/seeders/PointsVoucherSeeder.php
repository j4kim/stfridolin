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
        Article::where('type', ArticleType::PointsCredit)->delete();

        $pointsQuantities = [
            2000 => 4,
            1000 => 2,
            750 => 2,
            500 => 2,
            400 => 2,
            300 => 2,
            200 => 2,
            100 => 56,
        ];

        foreach ($pointsQuantities as $points => $quantity) {
            $article = Article::create([
                'type' => ArticleType::PointsCredit,
                'name' => "$points-points",
                'description' => number_format($points, thousands_separator: '’') . " points",
                'currency' => Currency::None,
                'price' => 0,
                'meta' => ['points' => $points, 'type' => 'points'],
            ]);

            Voucher::factory($quantity)->create(['article_id' => $article->id]);
        }
    }
}
