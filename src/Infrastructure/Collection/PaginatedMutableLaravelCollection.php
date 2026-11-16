<?php

namespace Aigletter\LaravelClean\Infrastructure\Collection;

use Aigletter\CleanCommon\Application\Collections\MutablePaginatedCollection;
use Aigletter\CleanCommon\Application\Collections\PaginatedCollection;
use Illuminate\Support\Collection as IlluminateCollection;

class PaginatedMutableLaravelCollection extends MutableLaravelCollection implements MutablePaginatedCollection
{
    public function __construct(IlluminateCollection $collection, private ?int $total = null)
    {
        parent::__construct($collection);
    }

    public function total(): int
    {
        return $this->total ?? $this->count();
    }

    public function toImmutable(): PaginatedCollection
    {
        return new PaginatedLaravelCollection(clone $this->collection, $this->total());
    }

    protected function newInstance(IlluminateCollection $collection): static
    {
        return new static($collection, $this->total);
    }
}
