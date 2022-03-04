<?php

namespace JustBetter\ErrorLogger\Listeners;

use JustBetter\ErrorLogger\Events\BeforeErrorCreate;
use JustBetter\ErrorLogger\Models\Error;

/**
 * Check if there is already an error that is the same as the one being reported.
 * If so, increment the count
 */
class IncrementExistingError
{
    public function handle(BeforeErrorCreate $event): bool
    {
        if ($event->error->dontGroup) {
            return true;
        }

        $start = match (config('laravel-error-logger.increment_interval')) {
            'monthly' => now()->subMonth(),
            'weekly' => now()->subWeek(),
            default => now()->startOfDay(),
        };

        $keys = [
            'group',
            'message',
            'model_id',
            'model_type',
            'details',
            'code'
        ];

        $equalError = Error::query()
            ->where($event->error->only($keys))
            ->whereDate('created_at', '>=', $start)
            ->orderByDesc('id')
            ->first();

        if ($equalError === null) {
            return true;
        }

        $equalError->update([
            'count' => $equalError->count + 1
        ]);

        return false; // Return false to not save this error
    }
}