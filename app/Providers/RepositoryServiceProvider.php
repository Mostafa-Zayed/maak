<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('App\Repositories\Contracts\UserInterface','App\Repositories\UserRepository');
        $this->app->bind('App\Repositories\Contracts\ServiceInterface','App\Repositories\ServiceRepository');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
