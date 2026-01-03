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
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('proposed_by')->nullable()->constrained('guests');
            $table->string('name');
            $table->string('artist_name');
            $table->string('spotify_uri');
            $table->string('img_url');
            $table->string('img_thumbnail_url');
            $table->json('spotify_data');
            $table->unsignedTinyInteger('priority')->default(0);
            $table->boolean('won')->nullable();
            $table->boolean('played')->nullable();
            $table->boolean('used')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
