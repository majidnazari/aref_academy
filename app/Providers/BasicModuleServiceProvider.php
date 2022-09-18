<?php

namespace App\Providers;

use App\BasicFacade\BasicModule;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Log;

class BasicModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('BasicModule', function()
        {
            //Log::info("the service provider basicmodule  is run.");
            //return new App\BasicFacade\BasicMethod;
            return new BasicModule;
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
