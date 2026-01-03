<?php

use App\Http\Controllers\FightController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\VoteController;
use App\Http\Middleware\EnsureMasterClient;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('spotify/devices', [SpotifyController::class, 'devices'])->name('spotify.devices');
    Route::get('spotify/playback-state', [SpotifyController::class, 'playbackState'])->name('spotify.playback-state');
    Route::put('spotify/select-device/{deviceId}', [SpotifyController::class, 'selectDevice'])->name('spotify.select-device');
    Route::post('master-client-id', [MasterController::class, 'setMasterClientId'])->name('master-client-id.set');

    Route::middleware(EnsureMasterClient::class)->group(function () {
        Route::put('spotify/play', [SpotifyController::class, 'play'])->name('spotify.play');
        Route::put('spotify/play/{trackUri}', [SpotifyController::class, 'playTrack'])->name('spotify.play-track');
        Route::put('spotify/pause', [SpotifyController::class, 'pause'])->name('spotify.pause');
        Route::put('fights/end', [FightController::class, 'end'])->name('fights.end');
        Route::post('fights/create-next', [FightController::class, 'createNext'])->name('fights.create-next');
    });
});

Route::get('spotify/search-tracks', [SpotifyController::class, 'searchTracks'])->name('spotify.search-tracks');
Route::get('master-client-id', [MasterController::class, 'getMasterClientId'])->name('master-client-id.get');
Route::get('fights/current', [FightController::class, 'current'])->name('fights.current');
Route::post('votes/{fight}/{track}', [VoteController::class, 'vote'])->name('votes.vote');
Route::post('tracks/{spotifyUri}', [TrackController::class, 'store'])->name('tracks.store');
Route::get('tracks/queue', [TrackController::class, 'queue'])->name('tracks.queue');
