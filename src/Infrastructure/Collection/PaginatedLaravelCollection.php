<?php

namespace Aigletter\LaravelClean\Infrastructure\Collection;

use Aigletter\CleanCommon\Domain\Collection\PaginatedCollection;
use Illuminate\Support\Collection;

class PaginatedLaravelCollection extends LaravelCollection implements PaginatedCollection
{
    public function __construct(Collection $collection, private ?int $total = null)
    {
        parent::__construct($collection);
    }

    public function total(): int
    {
        return $this->total;
    }

    protected function newInstance(Collection $collection): static
    {
        return new static($collection, $this->total);
    }
}