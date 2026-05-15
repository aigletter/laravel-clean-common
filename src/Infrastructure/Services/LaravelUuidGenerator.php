<?php

namespace Aigletter\LaravelClean\Infrastructure\Services;

use Aigletter\CleanCommon\Application\Services\IdGenerator;
use Illuminate\Support\Str;

class LaravelUuidGenerator implements IdGenerator
{
    public function generate(): string
    {
        return Str::uuid7()->toString();
    }
}