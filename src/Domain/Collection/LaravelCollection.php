<?php

namespace Aigletter\LaravelClean\Domain\Collection;

use Aigletter\CleanCommon\Domain\Collection\Collection as Contract;
use Illuminate\Support\Collection;
use Traversable;

class LaravelCollection implements Contract
{
    public function __construct(private Collection $collection)
    {
    }

    public function toArray(): array
    {
        return $this->collection->all();
    }

    public function map(callable $callback): static
    {
        return new static($this->collection->map($callback));
    }

    public function get(string|int $key, mixed $default = null): mixed
    {
        return $this->collection->get($key, $default);
    }

    public function set(string|int $key, mixed $value): void
    {
        $this->collection->put($key, $value);
    }

    public function has(int|string $key): bool
    {
        return $this->collection->has($key);
    }

    public function remove(string|int $key): void
    {
        $this->collection->forget($key);
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
        for ($i = count($value) - 1; $i >= 0; $i--) {
            $this->collection->prepend($value[$i]);
        }
    }

    public function each(callable $callback, ...$args): static
    {
        $this->collection->each($callback);
        return $this;
    }

    public function keyBy(callable|string $key): static
    {
        return new static($this->collection->keyBy($key));
    }

    public function pluck(callable|string $key): static
    {
        if ($key instanceof \Closure || (is_array($key) && count($key) === 2 && is_callable($key))) {
            return new static($this->collection->map(function (mixed $item, string|int $index) use ($key) {
                return $key($item, $index);
            }));
        }

        return new static($this->collection->keys()->combine($this->collection->pluck($key)));
    }

    public function keys(): static
    {
        return new static($this->collection->keys());
    }

    public function values(): static
    {
        return new static($this->collection->values());
    }

    public function slice(int $start, ?int $length = null): static
    {
        return new static($this->collection->slice($start, $length));
    }

    public function merge(?Contract $collection = null): static
    {
        return new static(
            $this->collection->merge(new Collection($collection->toArray()))
        );
    }

    public function getIterator(): Traversable
    {
        return $this->collection->getIterator();
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

    public function count(): int
    {
        return $this->collection->count();
    }

    public function groupBy(string|callable $callback): static
    {
        return (new static($this->collection->groupBy($callback)))->map(function (Collection $collection) {
            return new static($collection);
        });
    }

    public function first(?callable $callback = null, mixed $default = null): mixed
    {
        return $this->collection->first($callback);
    }

    public function contains(mixed $value): bool
    {
        return $this->collection->contains($value);
    }

    public function shuffle(): static
    {
        return new static($this->collection->shuffle());
    }

    public function chunk(int $length): static
    {
        return new static($this->collection->chunk($length));
    }

    public function filter(callable $callback = null): static
    {
        return new static($this->collection->filter($callback));
    }

    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        return $this->collection->reduce($callback, $initial);
    }

    public function collapse(): static
    {
        $collapsed = $this->collection->flatMap(function ($item) {
            if ($item instanceof self) {
                return $item->toArray();
            }
            return [$item];
        });

        return new self($collapsed);
    }
}