<?php

namespace App\Providers;

use App\AuthFacade\CheckAuth;
use Illuminate\Support\ServiceProvider;

class CheckAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('checkauth',function(){
            return new CheckAuth();
        });
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
