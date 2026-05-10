<?php

namespace Aigletter\LaravelClean\Infrastructure\Collection;

use Aigletter\CleanCommon\Application\Collections\PaginatedCollectionFactory;
use Aigletter\CleanCommon\Application\Collections\PaginatedCollection;
use Illuminate\Support\Collection as IlluminateCollection;

class PaginatedLaravelCollectionFactory implements PaginatedCollectionFactory
{

    public function make(array $items = [], int $total = 0): PaginatedCollection
    {
        return new PaginatedLaravelCollection(new IlluminateCollection($items), $total);
    }
}