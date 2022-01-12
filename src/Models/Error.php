<?php

namespace JustBetter\ErrorLogger\Models;

use Carbon\Carbon;
use JustBetter\ErrorLogger\Concerns\CanTruncate;
use Throwable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @property ?string $group
 * @property ?string $message
 * @property ?string $code
 * @property ?string $details
 * @property ?string $trace
 * @property ?string $vendor_trace
 * @property ?string $channel
 * @property ?string $model_type
 * @property ?int $model_id
 */
class Error extends Model
{
    use CanTruncate;

    protected $table = 'laravel_errors';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected array $truncate = [
        'details' => 'text',
        'trace' => 'text',
        'vendor_trace' => 'text',
    ];

    public function __set($key, $value)
    {
        $newValue = $this->canTruncate($key)
            ? $this->truncateValue($key, $value)
            : $value;

        parent::__set($key, $newValue);
    }

    public static function booted(): void
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

    public function withCode(string $code = null): self
    {
        $this->code = $code;

        return $this;
    }

    public function withDetails(string|array $details = null): self
    {
        $this->details = is_string($details)
            ? $details
            : json_encode($details, JSON_PRETTY_PRINT);

        return $this;
    }

    public function fromThrowable(Throwable $throwable): self
    {
        return $this
            ->withDetails($throwable->getMessage())
            ->withCode($throwable->getCode())
            ->withThrowable($throwable);
    }

    public function withThrowable(Throwable $throwable = null): self
    {
        if ($throwable) {

            $vendorTrace = $throwable->getTrace();
            $trace = collect($vendorTrace)
                ->filter(fn(array $step): bool => !isset($step['file']) || !Str::contains($step['file'], '/vendor/'))
                ->values()
                ->toArray();

            $this->vendor_trace = json_encode($vendorTrace, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $this->trace = json_encode($trace, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        } else {

            $this->vendor_trace = null;
            $this->trace = null;

        }

        return $this;
    }

    public function withChannel(string $channel = null): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function withModel(Model $model): self
    {
        $this->model_type = get_class($model);
        $this->model_id = $model->id;

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
