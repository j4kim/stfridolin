<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/users/{user}', function (User $user, Request $request) {
        $user->update($request->all());
        return $user;
    })->name('users.update');

    Route::get('inspire', function () {
        Artisan::call('inspire');
        return [
            'message' => Artisan::output(),
        ];
    })->name('inspire');
});

Route::post('flush-session', function () {
    session()->flush();
})->name('flush-session');
