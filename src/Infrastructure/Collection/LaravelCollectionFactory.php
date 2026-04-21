<?php

namespace Aigletter\LaravelClean\Infrastructure\Collection;

use Aigletter\CleanCommon\Domain\Collection\Collection;
use Aigletter\CleanCommon\Domain\Collection\MakeCollectionInterface;
use Aigletter\CleanCommon\Domain\Collection\PaginatedCollection;
use Illuminate\Support\Collection as IlluminateCollection;

class LaravelCollectionFactory implements MakeCollectionInterface
{
    public function make(array $items = []): Collection
    {
        return new LaravelCollection(new IlluminateCollection($items));
    }

    public function makePaginated(array $items = [], int $total = 0): PaginatedCollection
    {
        return new PaginatedLaravelCollection(new IlluminateCollection($items), $total);
    }
}