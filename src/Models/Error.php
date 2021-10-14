<?php

namespace JustBetter\LaravelErrorLogger\Models;

use Carbon\Carbon;
use Throwable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Error extends Model
{
    use HasFactory;

    protected $table = 'laravel_errors';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected $data = [];

    public static function booted()
    {
        static::created(function (self $error): void {
            if ($error->channel) {
                Log::channel($error->channel)->error($error->message);
            }
        });
    }

    public static function log(): self
    {
        return new static();
    }

    public function withGroup(string $group = null): self
    {
        $this->group = $group;

        return $this;
    }

    public function withMessage(string $message = null): self
    {
        $this->message = $message;

        return $this;
    }

    public function withThrowable(Throwable $throwable = null): self
    {
        if ($throwable) {

            $vendorTrace = $throwable->getTrace();
            $trace = collect($vendorTrace)
                ->filter(fn(array $step): bool => !Str::contains($step['file'], '/vendor/'))
                ->values()
                ->toArray();

            $this->vendor_trace = json_encode($vendorTrace, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $this->trace = json_encode($trace, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        } else {

            $this->vendor_trace = null;
            $this->trace = null;

        }

        if (strlen($this->vendor_trace) > 65535) {
            $this->vendor_trace = substr($this->vendor_trace, 0, 65535);
        }
        if (strlen($this->trace) > 65535) {
            $this->trace = substr($this->trace, 0, 65535);
        }

        return $this;
    }

    public function withChannel(string $channel = null): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function hasTrace(): bool
    {
        return $this->trace !== null;
    }

    public function scopeYesterday(Builder $query): Builder
    {
        return $query->whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'));
    }
}
