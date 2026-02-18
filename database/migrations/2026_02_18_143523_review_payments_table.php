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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropUnique(['stripe_id']);
            $table->string('stripe_id')->nuallable(true)->change();
            $table->renameColumn('stripe_status', 'status');
            $table->string('method')->nullable();
            $table->foreignId('article_id')->nullable()->constrained()->nullOnDelete();
            $table->string('description')->nullable();
            $table->decimal('original_amount', 8, 2)->nullable();
            $table->json('meta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('meta');
            $table->dropColumn('original_amount');
            $table->dropColumn('description');
            $table->dropForeign(['article_id']);
            $table->dropColumn('article_id');
            $table->dropColumn('method');
            $table->renameColumn('status', 'stripe_status');
            $table->string('stripe_id')->nuallable(false)->change();
            $table->unique(['stripe_id']);
        });
    }
};
