<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

Auth::routes();

Route::group(
    [
        'prefix' => 'dashboard',
        'middleware' => ['auth'],
    ],
    function () {
        Route::get('', [DashboardController::class, 'index'])
            ->name('dashboard');
    }
);

