<?php

use App\Http\Controllers\SpotifyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('spotify/playback-state', [SpotifyController::class, 'playbackState'])->name('spotify.playback-state');
});
