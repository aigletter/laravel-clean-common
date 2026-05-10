<?php

namespace Aigletter\LaravelClean\Infrastructure\Collection;

use Aigletter\CleanCommon\Domain\Collections\CollectionFactory;
use Aigletter\CleanCommon\Domain\Collections\Collection;
use Illuminate\Support\Collection as IlluminateCollection;

class LaravelCollectionFactory implements CollectionFactory
{
    public function make(array $items = []): Collection
    {
        return new LaravelCollection(new IlluminateCollection($items));
    }
}