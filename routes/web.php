<?php

use App\Http\Controllers\BlogPost\BlogPostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])
    ->name('home');
Route::get('/post/{id}', [WelcomeController::class, 'show'])
    ->name('show_blog_post');

Auth::routes();

Route::group(
    [
        'prefix' => 'dashboard',
        'middleware' => ['auth',],
    ],
    function () {
        Route::get('', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::group(
            [
                'prefix' => 'posts',
            ],
            function () {
                Route::get('', [BlogPostController::class, 'index'])
                    ->name('dashboard.posts');

                Route::post('', [BlogPostController::class, 'store']);

                Route::post(
                    'import-posts',
                    [BlogPostController::class, 'importPosts']
                )->name('dashboard.import_posts')
                ->middleware('super-user');
            }
        );
    }
);

