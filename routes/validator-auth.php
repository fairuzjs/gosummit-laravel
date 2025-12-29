<?php

use App\Http\Controllers\Validator\ValidatorAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Validator Authentication Routes
|--------------------------------------------------------------------------
|
| Routes khusus untuk autentikasi validator.
| Login validator terpisah dari login admin dan customer untuk keamanan.
|
*/

Route::prefix('validator')->name('validator.')->group(function () {
    Route::middleware('guest:validator')->group(function () {
        Route::get('login', [ValidatorAuthController::class, 'showLoginForm'])
            ->name('login');

        Route::post('login', [ValidatorAuthController::class, 'login']);
    });

    Route::middleware('auth:validator')->group(function () {
        Route::post('logout', [ValidatorAuthController::class, 'logout'])
            ->name('logout');
    });
});
