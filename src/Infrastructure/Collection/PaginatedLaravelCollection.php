<?php

namespace Aigletter\LaravelClean\Infrastructure\Collection;

use Aigletter\CleanCommon\Application\Collections\MutablePaginatedCollection;
use Aigletter\CleanCommon\Application\Collections\PaginatedCollection;
use Illuminate\Support\Collection;

class PaginatedLaravelCollection extends LaravelCollection implements PaginatedCollection
{
    public function __construct(Collection $collection, private ?int $total = null)
    {
        parent::__construct($collection);
    }

    public function total(): int
    {
        return $this->total !== null ? $this->total : $this->count();
    }

    protected function newInstance(Collection $collection): static
    {
        return new static($collection, $this->total);
    }

    public function toMutable(): MutablePaginatedCollection
    {
        return new PaginatedMutableLaravelCollection(clone $this->collection, $this->total());
    }
}