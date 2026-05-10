<?php

namespace Aigletter\LaravelClean\Infrastructure\Utils;

use Aigletter\CleanCommon\Utils\Helper\StringHelper;
use Illuminate\Support\Str;

class LaravelStringHelper implements StringHelper
{
    public function isLcfirst(string $value): bool
    {
        return !$this->isUcfirst($value);
    }

    public function isUcfirst(string $value): bool
    {
        return preg_match('/^\p{Lu}/u', $value);
    }

    public function lcfirst(string $value): string
    {
        return Str::lcfirst($value);
    }

    public function ucfirst(string $value): string
    {
        return Str::ucfirst($value);
    }

    public function camel(string $value): string
    {
        return Str::camel($value);
    }

    public function pascal(string $value): string
    {
        return Str::pascal($value);
    }

    public function snake(string $value): string
    {
        return Str::snake($value);
    }

    public function kebab(string $value): string
    {
        return Str::kebab($value);
    }

    public function studly(string $value): string
    {
        return Str::studly($value);
    }
}