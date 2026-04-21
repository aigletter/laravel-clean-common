<?php

namespace Tests\Integration\Framework;

use Aigletter\CleanCommon\Domain\Collection\Collection;
use Aigletter\CleanCommon\Domain\Collection\MakeCollectionInterface;
use Aigletter\CleanCommon\Domain\Collection\PaginatedCollection;
use Aigletter\LaravelClean\Infrastructure\Collection\LaravelCollection;
use Aigletter\LaravelClean\Framework\Providers\LaravelCleanServiceProvider;
use Orchestra\Testbench\TestCase;

class CollectionIntegrationTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LaravelCleanServiceProvider::class];
    }

    public function testFactoryIsRegistered()
    {
        $this->assertTrue($this->app->bound(MakeCollectionInterface::class));
        $factory = $this->app->make(MakeCollectionInterface::class);

        $collection = $factory->make();
        $this->assertInstanceOf(Collection::class, $collection);

        $collection = $factory->makePaginated();
        $this->assertInstanceOf(PaginatedCollection::class, $collection);
    }
}