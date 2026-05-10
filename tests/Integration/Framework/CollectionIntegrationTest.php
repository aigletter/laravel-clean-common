<?php

namespace Tests\Integration\Framework;

use Aigletter\CleanCommon\Domain\Collections\Collection;
use Aigletter\CleanCommon\Domain\Collections\CollectionFactory;
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
        $this->assertTrue($this->app->bound(CollectionFactory::class));
        $factory = $this->app->make(CollectionFactory::class);

        $collection = $factory->make();
        $this->assertInstanceOf(Collection::class, $collection);
    }
}