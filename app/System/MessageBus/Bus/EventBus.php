<?php
/** @author: Adam Pawełczyk */

namespace App\System\MessageBus\Bus;

use App\Modules\Shared\Bus\EventBus as EventBusInterface;
use App\System\MessageBus\Policy\StampPolicy;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseTransactionsManager;

readonly class EventBus implements EventBusInterface
{
    public function __construct(
        private Dispatcher                  $dispatcher,
        private DatabaseTransactionsManager $transactions,
        private StampPolicy                 $stampPolicy,
    ) {
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
            fn() => $this->dispatcher->dispatch($message)
        );
    }
}
