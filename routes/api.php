<?php

use App\Http\Controllers\SpotifyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('spotify/devices', [SpotifyController::class, 'devices'])->name('spotify.devices');
    Route::get('spotify/playback-state', [SpotifyController::class, 'playbackState'])->name('spotify.playback-state');
    Route::put('spotify/play', [SpotifyController::class, 'play'])->name('spotify.play');
    Route::put('spotify/pause', [SpotifyController::class, 'pause'])->name('spotify.pause');
    Route::put('spotify/select-device/{deviceId}', [SpotifyController::class, 'selectDevice'])->name('spotify.select-device');
});
