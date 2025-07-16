<?php

/** @author: Adam Pawełczyk */

namespace App\System\MessageBus\Bus;

use App\Modules\Shared\Bus\QueryBus as QueryBusInterface;
use Illuminate\Contracts\Container\Container;
use LogicException;

class QueryBus implements QueryBusInterface
{
    protected array $handlers = [];

    public function __construct(private readonly Container $container)
    {
    }

    public function register(string $queryClass, string $handlerClass): void
    {
        $this->handlers[$queryClass] = $handlerClass;
    }

    public function query(object $query): mixed
    {
        $queryClass = get_class($query);

        if (!isset($this->handlers[$queryClass])) {
            throw new LogicException("No handler registered for query: $queryClass");
        }

        $handler = $this->container->make($this->handlers[$queryClass]);

        return $handler($query);
    }
}
