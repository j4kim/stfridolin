<?php

use App\Models\Track;
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
        if (Schema::hasColumn('tracks', 'won')) {
            Schema::table('tracks', function (Blueprint $table) {
                $table->dropColumn('won');
            });
        }
        Schema::table('tracks', function (Blueprint $table) {
            $table->unsignedTinyInteger('priority')->default(config('jukeboxe.priorities.guest_added'))->change();
            $table->boolean('used')->nullable()->default(false)->change();
        });
        Schema::table('fights', function (Blueprint $table) {
            $table->foreignId('won_track_id')->nullable()->constrained('tracks');
        });
        Track::query()->whereNull('used')->update(['used' => false]);
        Track::query()->where('priority', 0)->update(['priority' => config('jukeboxe.priorities.reserve')]);
        Track::query()->where('priority', 1)->update(['priority' => config('jukeboxe.priorities.guest_added')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('tracks', 'won')) {
            Schema::table('tracks', function (Blueprint $table) {
                $table->boolean('won')->nullable();
            });
        }
        if (Schema::hasColumn('fights', 'won_track_id')) {
            Schema::table('fights', function (Blueprint $table) {
                $table->dropForeign('fights_won_track_id_foreign');
                $table->dropColumn('won_track_id');
            });
        }
        Track::query()->update(['priority' => 0]);
        Track::query()->where('used', 'is', 'false')->update(['used' => null]);
    }
};
