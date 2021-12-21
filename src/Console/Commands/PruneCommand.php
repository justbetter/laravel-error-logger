<?php

namespace JustBetter\ErrorLogger\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use JustBetter\ErrorLogger\Jobs\PruneJob;

class PruneCommand extends Command
{
    protected $signature = 'laravel-error-logger:prune {--hours=} {--all}';

    protected $description = 'Prune Laravel Error logs.';

    public function handle(): int
    {
        $hours = $this->option('hours');
        $all = $this->option('all');

        if (is_null($hours) && !$all) {

            $this->error('Incorrect usage. To prune all records, use the --all flag.');

            return static::FAILURE;

        }

        $carbon = $all
            ? null
            : Carbon::now()->subHours((int)$hours);

        PruneJob::dispatch($carbon);

        return static::SUCCESS;
    }
}
