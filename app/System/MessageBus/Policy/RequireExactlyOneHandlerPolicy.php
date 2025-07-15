<?php

/** @author: Adam Pawełczyk */

namespace App\System\MessageBus\Policy;

use LogicException;

class RequireExactlyOneHandlerPolicy
{
    public function isSatisfiedBy(array $handlers): bool
    {
        return count($handlers) === 1;
    }

    public function assert(string $messageClass, array $handlers): void
    {
        if (!$this->isSatisfiedBy($handlers)) {
            $count = count($handlers);

            throw new LogicException(sprintf("Message `%s` must have exactly one handler. Found: %d", $messageClass, $count));
        }
    }
}
