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
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('guest_id')->constrained();
            $table->foreignId('payment_id')->nullable()->constrained();
            $table->foreignId('article_id')->nullable()->constrained();
            $table->decimal('amount', 8, 2);
            $table->string('type');
            $table->json('meta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
