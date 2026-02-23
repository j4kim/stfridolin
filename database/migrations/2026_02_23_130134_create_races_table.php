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
        Schema::create('races', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('occurrence_id')->constrained()->cascadeOnDelete();
        });

        Schema::create('competitors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('image_path', 1024)->nullable();
        });

        Schema::create('competitor_race', function (Blueprint $table) {
            $table->foreignId('competitor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('race_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('races');
        Schema::dropIfExists('competitors');
        Schema::dropIfExists('competitor_race');
    }
};
