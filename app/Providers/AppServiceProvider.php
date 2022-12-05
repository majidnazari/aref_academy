<?php

namespace App\Providers;

use App\BasicFacade\CreateModel;
use Illuminate\Support\ServiceProvider;
use App\Repositories;
use App\Repositories\Interfaces;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
       
        // $this->app->bind(
        //     'App\Repositories\Interfaces\FaultRepositoryInterface',
        //     'App\Repositories\FaultRepository'
        // );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
