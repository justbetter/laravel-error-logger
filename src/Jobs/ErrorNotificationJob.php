<?php

namespace JustBetter\ErrorLogger\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use JustBetter\ErrorLogger\Models\Error;

class ErrorNotificationJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle(): void
    {
        $count = Error::yesterday()->count();

        if ($count === 0) {
            return;
        }

        $message = trans_choice('laravel-error-logger::messages.notification', $count, ['value' => $count]);

        /** @var string $channel */
        $channel = config('laravel-error-logger.notification.channel');

        if (strlen($channel) > 0) {
            Log::channel($channel)->info($message);
        }
    }
}
