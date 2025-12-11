<?php

use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
|
| Routes khusus untuk autentikasi admin dan validator.
| Login admin terpisah dari login customer untuk keamanan yang lebih baik.
|
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])
            ->name('login');

        Route::post('login', [AdminAuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])
            ->name('logout');
    });
});
