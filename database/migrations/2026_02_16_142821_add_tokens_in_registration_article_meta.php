<?php

use App\Enums\ArticleType;
use App\Models\Article;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $a = Article::firstWhere('type', ArticleType::Registration);
        if ($a && !$a['meta']) {
            $a->meta = ['tokens' => 20];
            $a->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
