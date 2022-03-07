<?php

namespace JustBetter\ErrorLogger\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use JustBetter\ErrorLogger\Models\Error;

trait HasErrors
{
    public function errors(): MorphMany
    {
        return $this->morphMany(Error::class, 'model');
    }
}