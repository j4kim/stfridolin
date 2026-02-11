<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Voucher::factory(9)->create(['article_id' => Article::firstWhere('name', '40-tokens')->id]);
        Voucher::factory(18)->create(['article_id' => Article::firstWhere('name', '100-tokens')->id]);
        Voucher::factory(18)->create(['article_id' => Article::firstWhere('name', '200-tokens')->id]);
        Voucher::factory(9)->create(['article_id' => Article::firstWhere('name', '400-tokens')->id]);
        Voucher::factory(6)->create(['article_id' => Article::firstWhere('name', '1000-tokens')->id]);
        Voucher::factory(3)->create(['article_id' => Article::firstWhere('name', '100000-tokens')->id]);
    }
}
