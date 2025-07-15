<?php

/** @author: Adam Pawełczyk */

namespace App\System\MessageBus;

use App\System\MessageBus\Policy\RequireExactlyOneHandlerPolicy;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

readonly class HandlerRegisterer
{
    public function __construct(
        private Container           $container,
        private HandlerDiscoverer   $discoverer,
        private HandlerPathProvider $paths
    ) {
    }

    public function register(): void
    {
        foreach ($this->paths->all() as $path) {
            $discovered = $this->discoverer->discover($path);

            foreach ($discovered as $messageClass => $handlers) {
                if (Str::contains($messageClass, '\\Command\\')) {
                    $this->registerCommand($messageClass, $handlers);
                } elseif (Str::contains($messageClass, '\\Query\\')) {
                    $this->registerQuery($messageClass, $handlers);
                } elseif (Str::contains($messageClass, '\\Event\\')) {
                    $this->registerEvent($messageClass, $handlers);
                }
            }
        }
    }

    private function registerCommand(string $messageClass, array $handlers): void
    {
        $policy = new RequireExactlyOneHandlerPolicy();
        $policy->assert($messageClass, $handlers);

        $this->container->bind($messageClass, $handlers[0]);

        Bus::map([$messageClass => $handlers[0]]);
    }

    private function registerQuery(string $messageClass, array $handlers): void
    {
        $policy = new RequireExactlyOneHandlerPolicy();
        $policy->assert($messageClass, $handlers);

        $queryBus = $this->container->make(QueryBus::class);
        $queryBus->register($messageClass, $handlers[0]);
    }

    private function registerEvent(string $messageClass, array $handlers): void
    {
        foreach ($handlers as $handler) {
            Event::listen($messageClass, $handler);
        }
    }
}
