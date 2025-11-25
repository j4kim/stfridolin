<?php

use App\Http\Controllers\SpotifyController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return view('vue-app');
})->name('vue-app');

Route::get('spotify-login', [SpotifyController::class, 'login'])->name('spotify-login');
Route::get('spotify-callback', [SpotifyController::class, 'callback'])->name('spotify-callback');
Route::get('spotify-remote', [SpotifyController::class, 'remote'])->name('spotify-remote');
