<?php

namespace App\Providers;

use App\Events\UpdateCourseStudentStatistics;
use App\Listeners\ApplyingCourseStudentStatistics;
use App\Listeners\ApplyingCourseStatistics;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;


use function Illuminate\Events\queueable;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            // UpdateCourseStudentStatistics::class,
            ApplyingCourseStudentStatistics::class,
            ApplyingCourseStatistics::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            UpdateCourseStudentStatistics::class,
            [ApplyingCourseStudentStatistics::class, 'handle'],

        );
        Event::listen(
            UpdateCourseStudentStatistics::class,
            [ApplyingCourseStatistics::class, 'handle']
        );
    }
}
