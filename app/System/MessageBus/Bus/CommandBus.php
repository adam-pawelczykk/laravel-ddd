<?php

/** @author: Adam Pawełczyk */

namespace App\System\MessageBus\Bus;

use App\Modules\Shared\Bus\CommandBus as CommandBusInterface;
use App\System\MessageBus\Policy\StampPolicy;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Database\DatabaseTransactionsManager;

readonly class CommandBus implements CommandBusInterface
{
    public function __construct(
        private Dispatcher                  $dispatcher,
        private DatabaseTransactionsManager $transactions,
        private StampPolicy                 $stampPolicy,
        private array                       $middleware = [],
    ) {
        $this->dispatcher->pipeThrough($this->middleware);
    }

    public function dispatch(object $message, array $stamps = []): void
    {
        $this->stampPolicy->apply($message, $stamps);
        $this->dispatcher->dispatch($message);
    }

    public function dispatchAfterCurrentStamp(object $message, array $stamps = []): void
    {
        $this->stampPolicy->apply($message, $stamps);
        $this->transactions->addCallback(
            fn () => $this->dispatcher->dispatch($message)
        );
    }
}
