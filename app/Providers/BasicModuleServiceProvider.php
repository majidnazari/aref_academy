<?php

namespace App\Providers;

use App\BasicFacade\UpdateCourseStudentReport;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class BasicModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('UpdateCourseStudentReport', function () {
            return new UpdateCourseStudentReport;
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
