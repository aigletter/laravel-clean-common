<?php

namespace Tests\Unit\Infrastructure\Collection;

use Aigletter\CleanCommon\Application\Collections\PaginatedCollection;
use Aigletter\LaravelClean\Infrastructure\Collection\PaginatedLaravelCollection;
use Illuminate\Support\Collection as IlluminateCollection;
use PHPUnit\Framework\TestCase;


class PaginatedLaravelCollectionTest extends TestCase
{
    public function testWith()
    {
        $items = $this->getTestData();
        $collection = new PaginatedLaravelCollection(new IlluminateCollection($items), 100);
        $collection = $collection->withKey('key', 'value');

        $this->assertEquals(100, $collection->total());
    }

    public function testMap()
    {
        $items = $this->getTestData();
        $collection = new PaginatedLaravelCollection(new IlluminateCollection($items), 100);

        $result = $collection->map(function ($item) {
            return $item['value'];
        });

        $this->assertInstanceOf(PaginatedCollection::class, $result);
        $this->assertSame(array_column($items, 'value'), $result->toArray());
    }

    public function testTotal()
    {
        $items = $this->getTestData();
        $collection = new PaginatedLaravelCollection(new IlluminateCollection($items), 100);

        $result = $collection->total();

        $this->assertEquals(100, $result);

        $items = $this->getTestData();
        $collection = new PaginatedLaravelCollection(new IlluminateCollection($items));

        $result = $collection->total();

        $this->assertEquals(2,$result);
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
}