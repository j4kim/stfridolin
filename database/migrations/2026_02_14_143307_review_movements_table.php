<?php

use App\Enums\MovementType;
use App\Models\Guest;
use App\Models\Movement;
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
        Schema::table('movements', function (Blueprint $table) {
            $table->integer('chf')->nullable();
            $table->integer('tokens')->nullable();
            $table->integer('points')->nullable();
        });

        Movement::all()->each(function (Movement $movement) {
            if ($movement->type === MovementType::BuyTokens) {
                $movement->chf = -$movement->amount;
                $movement->tokens = $movement->meta['tokens'];
            } else if ($movement->type === MovementType::Registration) {
                $movement->chf = -$movement->amount;
                $movement->tokens = 20;
            } else if ($movement->type === MovementType::SpendTokens) {
                $movement->tokens = -$movement->amount;
            }
            $movement->save();
        });

        Guest::each(fn(Guest $guest) => $guest->recomputeTokensAndPoints()->save());

        Schema::table('movements', function (Blueprint $table) {
            $table->dropColumn('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movements', function (Blueprint $table) {
            $table->decimal('amount', 8, 2);
            $table->dropColumn('chf');
            $table->dropColumn('tokens');
            $table->dropColumn('points');
        });
    }
};
