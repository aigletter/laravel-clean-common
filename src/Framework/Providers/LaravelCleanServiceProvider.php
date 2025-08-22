<?php

namespace Aigletter\LaravelClean\Framework\Providers;

use Aigletter\CleanCommon\Domain\Collection\CollectionFactory;
use Aigletter\CleanCommon\Domain\Collection\MakeCollectionInterface;
use Aigletter\LaravelClean\Domain\Collection\LaravelCollectionFactory;
use Illuminate\Support\ServiceProvider;

class LaravelCleanServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MakeCollectionInterface::class, LaravelCollectionFactory::class);
    }

    public function boot()
    {
        CollectionFactory::setFactory($this->app->get(MakeCollectionInterface::class));
    }
}