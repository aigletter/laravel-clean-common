<?php

namespace Aigletter\LaravelClean\Infrastructure\Collection;

use Aigletter\CleanCommon\Domain\Collections\CollectionOperations;
use Illuminate\Support\Collection as IlluminateCollection;
use Traversable;

abstract class AbstractLaravelCollection implements CollectionOperations
{
    public function __construct(protected readonly IlluminateCollection $collection)
    {
    }

    public function toArray(): array
    {
        return $this->collection->all();
    }

    public function get(string|int $key, mixed $default = null): mixed
    {
        return $this->collection->get($key, $default);
    }

    public function has(int|string $key): bool
    {
        return $this->collection->has($key);
    }

    public function count(): int
    {
        return $this->collection->count();
    }

    public function getIterator(): Traversable
    {
        return $this->collection->getIterator();
    }

    public function first(?callable $callback = null, mixed $default = null): mixed
    {
        return $this->collection->first($callback, $default);
    }

    public function contains(mixed $value): bool
    {
        return $this->collection->contains($value);
    }

    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        return $this->collection->reduce($callback, $initial);
    }

    public function random(): mixed
    {
        return $this->collection->random();
    }

    public function search(mixed $value, bool $strict = false): mixed
    {
        return $this->collection->search($value, $strict);
    }

    public function map(callable $callback): static
    {
        return $this->newInstance($this->collection->map($callback));
    }

    public function each(callable $callback, ...$args): static
    {
        $this->collection->each($callback);
        return $this;
    }

    public function keyBy(callable|string $key): static
    {
        return $this->newInstance($this->collection->keyBy($key));
    }

    public function pluck(callable|string $key): static
    {
        if ($key instanceof \Closure || (is_array($key) && count($key) === 2 && is_callable($key))) {
            return $this->newInstance($this->collection->map(fn(mixed $item, string|int $index) => $key($item, $index)));
        }
        return $this->newInstance($this->collection->keys()->combine($this->collection->pluck($key)));
    }

    public function keys(): static
    {
        return $this->newInstance($this->collection->keys());
    }

    public function values(): static
    {
        return $this->newInstance($this->collection->values());
    }

    public function slice(int $start, ?int $length = null): static
    {
        return $this->newInstance($this->collection->slice($start, $length));
    }

    public function merge(CollectionOperations $collection): static
    {
        return $this->newInstance($this->collection->merge(new IlluminateCollection($collection->toArray())));
    }

    public function groupBy(string|callable $key): static
    {
        return $this->newInstance($this->collection->groupBy($key))->map(
            fn(IlluminateCollection $collection) => $this->newNestedInstance($collection)
        );
    }

    public function shuffle(): static
    {
        return $this->newInstance($this->collection->shuffle());
    }

    public function chunk(int $length): static
    {
        return $this->newInstance($this->collection->chunk($length));
    }

    public function filter(?callable $callback = null): static
    {
        return $this->newInstance($this->collection->filter($callback));
    }

    public function unique(string|callable|null $key = null, bool $strict = false): static
    {
        return $this->newInstance($this->collection->unique($key, $strict));
    }

    public function sort(?callable $callback = null): static
    {
        return $this->newInstance($this->collection->sort($callback));
    }

    public function sortBy(callable $callback, int $options = SORT_REGULAR, bool $descending = false): static
    {
        return $this->newInstance($this->collection->sortBy($callback, $options, $descending));
    }

    public function empty(): static
    {
        return $this->newInstance($this->collection->empty());
    }

    public function collapse(): static
    {
        $collapsed = $this->collection->flatMap(function ($item) {
            return $item instanceof self ? $item->toArray() : [$item];
        });
        return $this->newInstance($collapsed);
    }

    abstract protected function newInstance(IlluminateCollection $collection): static;

    protected function newNestedInstance(IlluminateCollection $collection): static
    {
        return new static($collection);
    }
}
