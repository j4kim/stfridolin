<?php

use App\Http\Controllers\SpotifyController;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return view('vue-app');
})->name('vue-app');

Route::get('spotify-login', [SpotifyController::class, 'login'])->name('spotify-login');
Route::get('spotify-callback', [SpotifyController::class, 'callback'])->name('spotify-callback');
Route::get('spotify-devices', [SpotifyController::class, 'devices'])->name('spotify-devices');

Route::view('guests/login', 'guests.login')->name('guests.login');
Route::post('guests/login', function (Request $request) {
    $guest = Guest::where('key', $request->key)->firstOrFail();
    session(['guest' => $guest]);
    return redirect('/');
})->name('guests.authenticate');
