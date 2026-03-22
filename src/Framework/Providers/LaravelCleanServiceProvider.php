<?php

namespace Aigletter\LaravelClean\Framework\Providers;

use Aigletter\CleanCommon\Application\Contracts\IdGenerator;
use Aigletter\CleanCommon\Domain\Collection\CollectionFactory;
use Aigletter\CleanCommon\Domain\Collection\MakeCollectionInterface;
use Aigletter\LaravelClean\Infrastructure\Collection\LaravelCollectionFactory;
use Aigletter\LaravelClean\Infrastructure\Services\LaravelUuidGenerator;
use Illuminate\Support\ServiceProvider;

class LaravelCleanServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MakeCollectionInterface::class, LaravelCollectionFactory::class);

        $this->app->singletonIf(IdGenerator::class, LaravelUuidGenerator::class);
    }

    public function boot()
    {
        CollectionFactory::setFactory($this->app->get(MakeCollectionInterface::class));
    }
}