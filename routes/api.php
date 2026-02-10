<?php

use App\Http\Controllers\FightController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VoucherController;
use App\Http\Middleware\AuthenticateGuest;
use App\Http\Middleware\EnsureMasterClient;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('spotify/devices', [SpotifyController::class, 'devices'])->name('spotify.devices');
    Route::get('spotify/playback-state', [SpotifyController::class, 'playbackState'])->name('spotify.playback-state');
    Route::put('spotify/select-device/{deviceId}', [SpotifyController::class, 'selectDevice'])->name('spotify.select-device');
    Route::post('master-client-id', [MasterController::class, 'setMasterClientId'])->name('master-client-id.set');
    Route::get('guests', [GuestController::class, 'index'])->name('guests.index');

    Route::middleware(EnsureMasterClient::class)->group(function () {
        Route::put('spotify/play', [SpotifyController::class, 'play'])->name('spotify.play');
        Route::put('spotify/play/{trackUri}', [SpotifyController::class, 'playTrack'])->name('spotify.play-track');
        Route::post('spotify/skip', [SpotifyController::class, 'skip'])->name('spotify.skip');
        Route::put('spotify/pause', [SpotifyController::class, 'pause'])->name('spotify.pause');
        Route::put('fights/{fight}/end', [FightController::class, 'end'])->name('fights.end');
        Route::post('fights/create-first', [FightController::class, 'createFirst'])->name('fights.create-first');
        Route::post('fights/{fight}/create-next', [FightController::class, 'createNext'])->name('fights.create-next');
    });
});

Route::middleware(AuthenticateGuest::class)->group(function () {
    Route::get('spotify/search-tracks', [SpotifyController::class, 'searchTracks'])->name('spotify.search-tracks');
    Route::get('fights/current', [FightController::class, 'current'])->name('fights.current');
    Route::post('votes/{fight}/{track}', [VoteController::class, 'vote'])->name('votes.vote');
    Route::post('tracks/{spotifyUri}', [TrackController::class, 'store'])->name('tracks.store');
    Route::get('tracks/queue', [TrackController::class, 'queue'])->name('tracks.queue');
    Route::post('payments/{article}', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('payments/{payment}', [PaymentController::class, 'get'])->name('payments.get');
    Route::put('payments/{payment}/toggle-cover-fees', [PaymentController::class, 'toggleCoverFees'])->name('payments.toggle-cover-fees');
    Route::get('vouchers/{voucher}', [VoucherController::class, 'get'])->name('vouchers.get');
    Route::post('vouchers/{voucher}/use', [VoucherController::class, 'use'])->name('vouchers.use');
});

Route::post('guests', [GuestController::class, 'storeMany'])->name('guests.storeMany');
Route::get('guests/{key}', [GuestController::class, 'get'])->name('guests.get');
