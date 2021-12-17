<?php

namespace JustBetter\LaravelErrorLogger\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JustBetter\LaravelErrorLogger\Models\Error;

class PruneJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?Carbon $carbon;

    public function __construct(Carbon $carbon = null)
    {
        $this->carbon = $carbon;
    }

    public function handle(): void
    {
        $query = Error::query();

        if (!is_null($this->carbon)) {
            $query->where('created_at', '<', $this->carbon->format('Y-m-d H:i:s'));
        }

        $query->delete();
    }
}
