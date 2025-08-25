<?php

namespace Tests\Unit\Domain\Collection;

use Aigletter\CleanCommon\Domain\Collection\Collection;
use Aigletter\LaravelClean\Domain\Collection\LaravelCollection;
use Illuminate\Support\Collection as IlluminateCollection;
use PHPUnit\Framework\TestCase;
use stdClass;

class LaravelCollectionTest extends TestCase
{
    public function testUnshift()
    {
        $array = [3, 4, 5];
        $unshift = [1, 2];
        $collection = new LaravelCollection(new IlluminateCollection($array));
        array_unshift($array, ...$unshift);
        $collection->unshift(...$unshift);
        $this->assertEquals($array, $collection->toArray());
    }

    public function testKeyBy()
    {
        $items = $this->makeTestEntities();
        $collection = new LaravelCollection(new IlluminateCollection($items));
        $result = $collection->keyBy(function (object $entity) {
            return $entity->getKey();
        });

        $this->assertSame(['first', 'second'], array_keys($result->toArray()));
    }

    public function testPluckPrimitive()
    {
        $items = $this->getTestData();
        $collection = new LaravelCollection(new IlluminateCollection($items));
        $result = $collection->pluck('value');
        $this->assertSame(array_column($items, 'value'), $result->toArray());
    }

    public function testPluckCallback()
    {
        $items = $this->makeTestEntities();
        $collection = new LaravelCollection(new IlluminateCollection($items));
        $result = $collection->pluck(function (object $entity) {
            return $entity->getValue();
        });

        $this->assertSame(['one', 'two'], $result->toArray());
    }

    public function testKeyByPluckPrimitive()
    {
        $items = $this->getTestData();
        $collection = new LaravelCollection(new IlluminateCollection($items));
        $result = $collection->keyBy('key')->pluck('value');
        $this->assertSame(array_column($this->getTestData(), 'value', 'key'), $result->toArray());
    }

    public function testGroupBy()
    {
        $items = $this->makeTestEntities();
        $collection = new LaravelCollection(new IlluminateCollection($items));
        $result = $collection->groupBy(function (object $entity) {
            return $entity->getKey();
        });
        $this->assertInstanceOf(Collection::class, $result->get('first'));
        $this->assertCount(2, $result);
    }

    private function makeTestEntities(): array
    {
        $result = [];
        foreach ($this->getTestData() as $item) {
            $result[] = $this->makeTestEntity($item['key'], $item['value']);
        }
        return $result;
    }

    private function getTestData(): array
    {
        return [
            [
                'key' => 'first',
                'value' => 'one',
            ],
            [
                'key' => 'second',
                'value' => 'two'
            ],
        ];
    }

    private function makeTestEntity(string $key, string $value): object
    {
        return new class($key, $value) extends stdClass
        {
            public function __construct(private string $key, private string $value)
            {}

            public function getKey(): string
            {
                return $this->key;
            }

            public function getValue(): string
            {
                return $this->value;
            }
        };
    }
}