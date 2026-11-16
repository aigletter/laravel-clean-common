<?php

namespace Aigletter\LaravelClean\Infrastructure\Collection;

use Aigletter\CleanCommon\Domain\Collections\Collection;
use Aigletter\CleanCommon\Domain\Collections\MutableCollection;
use Illuminate\Support\Collection as IlluminateCollection;

class MutableLaravelCollection extends AbstractLaravelCollection implements MutableCollection
{
    public function toImmutable(): Collection
    {
        return new LaravelCollection(clone $this->collection);
    }

    public function set(string|int $key, mixed $value): void
    {
        $this->collection->put($key, $value);
    }

    public function remove(string|int $key): void
    {
        $this->collection->forget([$key]);
    }

    public function push(mixed ...$value): void
    {
        $this->collection->push(...$value);
    }

    public function pop(): mixed
    {
        return $this->collection->pop();
    }

    public function shift(): mixed
    {
        return $this->collection->shift();
    }

    public function unshift(mixed ...$value): void
    {
        $this->collection->unshift(...$value);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->collection->offsetExists($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->collection->offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->collection->offsetSet($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->collection->offsetUnset($offset);
    }

    protected function newInstance(IlluminateCollection $collection): static
    {
        return new static($collection);
    }
}
