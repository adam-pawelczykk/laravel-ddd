<?php

/** @author: Adam Pawełczyk */

namespace Tests\Utils;

use App\Modules\Shared\Bus\CommandBus;
use App\Modules\Shared\Bus\EventBus;
use App\System\MessageBus\Policy\StampPolicy;

class InMemoryMessageBus implements CommandBus, EventBus
{
    private array $memory = [];
    private StampPolicy $stampPolicy;

    public function __construct()
    {
        $this->stampPolicy = new StampPolicy();
    }

    public function dispatch(object $message, array $stamps = []): void
    {
        $this->stampPolicy->apply($message, $stamps);
        $this->memory[] = $message;
    }

    public function dispatchAfterCurrentStamp(object $message, array $stamps = []): void
    {
        $this->stampPolicy->apply($message, $stamps);
        $this->memory[] = $message;
    }

    public function getMessages(): array
    {
        return $this->memory;
    }

    /**
     * @template T of object
     * @param class-string<T> $className
     * @return T|null
     */
    public function getLastMessageByClass(string $className): ?object
    {
        $messages = $this->getMessagesByClass($className);
        return empty($messages) ? null : end($messages);
    }

    /**
     * @template T of object
     * @param class-string<T> $className
     * @return list<T>
     */
    public function getMessagesByClass(string $className): array
    {
        return array_filter($this->memory, fn ($message) => $message instanceof $className);
    }
}
