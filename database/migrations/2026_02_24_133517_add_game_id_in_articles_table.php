<?php

use App\Enums\ArticleType;
use App\Models\Article;
use App\Models\Game;
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
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('game_id')->nullable()->constrained()->cascadeOnDelete();
        });

        $jukeboxe = Game::where('name', 'jukeboxe')->first();
        if (!$jukeboxe) {
            return;
        }
        Article::where('type', 'jukeboxe')
            ->update([
                'game_id' => $jukeboxe->id,
                'type' => ArticleType::Participation,
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropColumn('game_id');
        });
    }
};
