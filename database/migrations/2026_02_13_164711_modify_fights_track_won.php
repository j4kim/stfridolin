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
        Schema::table('tracks', function (Blueprint $table) {
        $table->dropColumn('won');
    });
    Schema::table('fights', function (Blueprint $table) {
        $table->foreignId('won_track_id')->nullable()->constrained('tracks');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        
        Schema::table('tracks', function (Blueprint $table) {
        $table->boolean('won')->nullable();
    });
    Schema::table('fights', function (Blueprint $table) {
        $table->dropForeign('won_track_id');
    });
    }
};
