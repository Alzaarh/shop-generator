<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\SignupRequest::class => [
            \App\Listeners\SaveUserInMemory::class,
            \App\Listeners\SendVerificationEmail::class,
        ],
    ];
}
