<?php

namespace Aigletter\LaravelClean\Infrastructure\Collection;

use Aigletter\CleanCommon\Domain\Collections\Collection;
use Aigletter\CleanCommon\Domain\Collections\MutableCollection;
use Illuminate\Support\Collection as IlluminateCollection;

class LaravelCollection extends AbstractLaravelCollection implements Collection
{
    public function toMutable(): MutableCollection
    {
        return new MutableLaravelCollection(clone $this->collection);
    }

    public function withKey(int|string $key, mixed $value): static
    {
        $collection = clone $this->collection;
        $collection->put($key, $value);

        return $this->newInstance($collection);
    }

    public function withoutKey(int|string $key): static
    {
        $collection = clone $this->collection;
        $collection->forget([$key]);

        return $this->newInstance($collection);
    }

    public function withAppended(...$value): static
    {
        $collection = clone $this->collection;
        $collection->push(...$value);

        return $this->newInstance($collection);
    }

    public function withoutLast(): static
    {
        $collection = clone $this->collection;
        $collection->pop();

        return $this->newInstance($collection);
    }

    public function withPrepended(...$value): static
    {
        $collection = clone $this->collection;
        $collection->unshift(...$value);

        return $this->newInstance($collection);
    }

    public function withoutFirst(): static
    {
        $collection = clone $this->collection;
        $collection->shift();

        return $this->newInstance($collection);
    }

    protected function newInstance(IlluminateCollection $collection): static
    {
        return new static($collection);
    }
}
