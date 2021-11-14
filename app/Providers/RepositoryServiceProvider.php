<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories;
use App\Repositories\Interfaces;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(
        //     'App\Repositories\FaultRepositoryInterface',
        //     'App\Repositories\FaultRepository'
        // );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
