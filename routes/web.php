<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\SpotifyController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return view('vue-app');
})->name('vue-app');

Route::get('spotify-login', [SpotifyController::class, 'login'])->name('spotify-login');
Route::get('spotify-callback', [SpotifyController::class, 'callback'])->name('spotify-callback');
Route::get('spotify-devices', [SpotifyController::class, 'devices'])->name('spotify-devices');

Route::post('payments/stripe-webhook', [PaymentController::class, 'stripeWebhook'])->name('payments.stripe-webhook')->withoutMiddleware(VerifyCsrfToken::class);

Route::middleware('auth')->group(function () {
    Route::get('qr-redirect', [QrController::class, 'redirect'])->name('qr-redirect');
});
