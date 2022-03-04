<?php

namespace JustBetter\ErrorLogger\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use JustBetter\ErrorLogger\Models\Error;

class BeforeErrorCreate
{
    use Dispatchable, SerializesModels;

    public function __construct(public Error $error)
    {
    }
}