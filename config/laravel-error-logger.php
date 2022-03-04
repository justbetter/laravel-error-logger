<?php

return [
    'notification' => [
        'channel' => env('LARAVEL_ERROR_NOTIFICATION_CHANNEL', 'stack'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Increment Interval
    |--------------------------------------------------------------------------
    |
    | This value is how long error logs should be incremented when equals.
    | When the same error is logged multiple times the original logged
    | will be incremented. Allowed values: daily, weekly, monthly
    |
    */

    'increment_interval' => 'daily'
];
