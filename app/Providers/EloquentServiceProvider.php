<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\User;
use App\Observers\BlogPostObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class EloquentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        BlogPost::observe(BlogPostObserver::class);
    }
}
