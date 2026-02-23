<?php

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
        Schema::dropIfExists('votes');

        Schema::table('movements', function (Blueprint $table) {
            $table->foreignId('game_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('occurence_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('competitor_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('fight_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('voted_track_id')->nullable()->constrained('tracks')->nullOnDelete();
            $table->foreignId('added_track_id')->nullable()->constrained('tracks')->nullOnDelete();
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movements', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropForeign(['occurence_id']);
            $table->dropForeign(['competitor_id']);
            $table->dropForeign(['fight_id']);
            $table->dropForeign(['voted_track_id']);
            $table->dropForeign(['added_track_id']);
            $table->dropColumn(['game_id', 'occurence_id', 'competitor_id', 'fight_id', 'voted_track_id', 'added_track_id']);
            $table->dropIndex(['type']);
        });

        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('guest_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('track_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fight_id')->constrained()->cascadeOnDelete();
        });
    }
};
