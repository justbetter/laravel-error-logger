<?php

namespace JustBetter\LaravelErrorLogger\Traits;

use JustBetter\LaravelErrorLogger\Exceptions\TruncateException;

trait CanTruncate
{
    protected array $truncate = [];

    protected function canTruncate(string $key): bool
    {
        return isset($this->truncate[$key]);
    }

    protected function truncateValue(string $key, $value = null)
    {
        $function = 'truncate' . ucfirst($this->truncate[$key]);

        if (!method_exists($this, $function)) {
            throw new TruncateException('Method "' . $function . '" not available on "' . get_class($this) . '".');
        }

        return $this->$function($value);
    }

    protected function truncateText($value = null, int $size = 65535)
    {
        if (is_null($value)) {
            return null;
        }

        if (is_string($value) && strlen($value) > $size) {
            return substr($value, 0, $size);
        }

        return $value;
    }
}