<?php

use App\Http\Controllers\SpotifyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('spotify/devices', [SpotifyController::class, 'devices'])->name('spotify.devices');
});
