<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GuestSeeder::class,
            TrackSeeder::class,
            GameSeeder::class,
            ArticleSeeder::class,
            VoucherSeeder::class,
            PointsVoucherSeeder::class,
            SponsorSeeder::class,
            GameArticleSeeder::class,
            CompetitorSeeder::class,
        ]);
    }
}
