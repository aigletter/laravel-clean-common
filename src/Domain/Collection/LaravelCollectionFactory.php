<?php

namespace Aigletter\LaravelClean\Domain\Collection;

use Aigletter\CleanCommon\Domain\Collection\Collection;
use Aigletter\CleanCommon\Domain\Collection\MakeCollectionInterface;
use Illuminate\Support\Collection as IlluminateCollection;

class LaravelCollectionFactory implements MakeCollectionInterface
{
    public function make(array $items = []): Collection
    {
        return new LaravelCollection(new IlluminateCollection($items));
    }
}