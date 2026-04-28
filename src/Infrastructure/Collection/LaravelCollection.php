<?php

namespace Aigletter\LaravelClean\Infrastructure\Collection;

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
        return $this->newInstance($this->collection->map($callback));
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
        return $this->newInstance($this->collection->keyBy($key));
    }

    public function pluck(callable|string $key): static
    {
        if ($key instanceof \Closure || (is_array($key) && count($key) === 2 && is_callable($key))) {
            return $this->newInstance(
                $this->collection->map(function (mixed $item, string|int $index) use ($key) {
                    return $key($item, $index);
                })
            );
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

    public function merge(?Contract $collection = null): static
    {
        return $this->newInstance(
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
        return ($this->newInstance($this->collection->groupBy($callback)))->map(function (Collection $collection) {
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

        return $this->newInstance($collapsed);
    }

    public function random(): mixed
    {
        return $this->collection->random();
    }

    public function unique(): static
    {
        return $this->newInstance($this->collection->unique());
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
        $collection->forget($key);

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

    public function sort($callback = null): static
    {
        return $this->newInstance($this->collection->sort($callback));
    }

    public function sortBy($callback, $options = SORT_REGULAR, $descending = false): static
    {
        return $this->newInstance($this->collection->sortBy($callback, $options, $descending));
    }

    protected function newInstance(Collection $collection): static
    {
        return new static($collection);
    }
}