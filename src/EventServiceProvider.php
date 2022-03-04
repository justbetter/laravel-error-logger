<?php

namespace JustBetter\ErrorLogger;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use JustBetter\ErrorLogger\Events\BeforeErrorCreate;
use JustBetter\ErrorLogger\Listeners\IncrementExistingError;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        BeforeErrorCreate::class => [
            IncrementExistingError::class
        ]
    ];
}