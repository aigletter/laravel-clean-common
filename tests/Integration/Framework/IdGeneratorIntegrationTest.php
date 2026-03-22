<?php

namespace Tests\Integration\Framework;

use Aigletter\CleanCommon\Application\Contracts\IdGenerator;
use Aigletter\LaravelClean\Infrastructure\Services\LaravelUuidGenerator;
use Aigletter\LaravelClean\Framework\Providers\LaravelCleanServiceProvider;
use Orchestra\Testbench\TestCase;

class IdGeneratorIntegrationTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LaravelCleanServiceProvider::class];
    }

    public function testGeneratorIsRegistered()
    {
        $this->assertTrue($this->app->bound(IdGenerator::class));
        $generator = $this->app->make(IdGenerator::class);
        $this->assertInstanceOf(LaravelUuidGenerator::class, $generator);
    }
}