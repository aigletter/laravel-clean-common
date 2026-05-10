<?php

namespace Integration\Framework;

use Aigletter\CleanCommon\Application\Collections\PaginatedCollectionFactory;
use Aigletter\CleanCommon\Application\Collections\PaginatedCollection;
use Aigletter\LaravelClean\Framework\Providers\LaravelCleanServiceProvider;
use Orchestra\Testbench\TestCase;

class PaginatedCollectionIntegrationTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LaravelCleanServiceProvider::class];
    }

    public function testFactoryIsRegistered()
    {
        $this->assertTrue($this->app->bound(PaginatedCollectionFactory::class));
        $factory = $this->app->make(PaginatedCollectionFactory::class);

        $collection = $factory->make();
        $this->assertInstanceOf(PaginatedCollection::class, $collection);
    }
}