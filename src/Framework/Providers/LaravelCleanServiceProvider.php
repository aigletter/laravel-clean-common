<?php

namespace Aigletter\LaravelClean\Framework\Providers;

use Aigletter\CleanCommon\Application\Services\IdGenerator;
use Aigletter\CleanCommon\Domain\Collections\CollectionFactory;
use Aigletter\CleanCommon\Application\Collections\PaginatedCollectionFactory;
use Aigletter\CleanCommon\Utils\Helper\StringHelper;
use Aigletter\LaravelClean\Infrastructure\Collection\LaravelCollectionFactory;
use Aigletter\LaravelClean\Infrastructure\Collection\PaginatedLaravelCollectionFactory;
use Aigletter\LaravelClean\Infrastructure\Services\LaravelUuidGenerator;
use Aigletter\LaravelClean\Infrastructure\Utils\LaravelStringHelper;
use Illuminate\Support\ServiceProvider;

class LaravelCleanServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CollectionFactory::class, LaravelCollectionFactory::class);
        $this->app->singleton(PaginatedCollectionFactory::class, PaginatedLaravelCollectionFactory::class);

        $this->app->singletonIf(IdGenerator::class, LaravelUuidGenerator::class);

        $this->app->singleton(StringHelper::class, LaravelStringHelper::class);
    }

    public function boot()
    {
        //CollectionFactory::setFactory($this->app->get(MakeCollectionInterface::class));
    }
}