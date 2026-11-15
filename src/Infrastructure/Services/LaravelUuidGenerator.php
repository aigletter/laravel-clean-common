<?php

namespace Aigletter\LaravelClean\Infrastructure\Services;

use Aigletter\CleanCommon\Domain\Services\IdGenerator;
use Illuminate\Support\Str;

class LaravelUuidGenerator implements IdGenerator
{
    public function generate(): string
    {
        return Str::uuid7()->toString();
    }
}