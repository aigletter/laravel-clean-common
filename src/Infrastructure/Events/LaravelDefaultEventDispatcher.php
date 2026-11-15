<?php

namespace Aigletter\LaravelClean\Infrastructure\Events;

use Aigletter\CleanCommon\Application\Events\Context;
use Aigletter\CleanCommon\Application\Events\DefaultEventDispatcher;
use Aigletter\CleanCommon\Application\Events\EventListener;
use Aigletter\CleanCommon\Domain\Events\Event;
use Psr\Container\ContainerInterface;

class LaravelDefaultEventDispatcher extends DefaultEventDispatcher
{
    public function __construct(private readonly ContainerInterface $container) {}

    public function addListener(string $event, callable|EventListener|string $listener): void
    {
        if (is_string($listener)) {
            $listener = $this->makeListener($listener);
        }

        parent::addListener($event, $listener);;
    }

    private function makeListener(string $listener): callable
    {
        if (!is_a($listener, EventListener::class, true)) {
            throw new \RuntimeException('Unsupported listener type');
        }

        return function (Event $event, ?Context $context) use ($listener) {
            $listener = $this->container->get($listener);
            return $listener->handle($event, $context);
        };
    }
}