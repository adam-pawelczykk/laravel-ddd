<?php

/** @author: Adam Pawełczyk */

namespace App\System\MessageBus\Policy;

use App\Modules\Shared\Bus\StampedMessage;
use App\System\MessageBus\Stamp\StampInterface;
use RuntimeException;

class StampPolicy
{
    /**
     * @param object $message
     * @param StampInterface[] $stamps
     * @return void
     */
    public function apply(object $message, array $stamps): void
    {
        if (empty($stamps)) {
            return;
        }

        if (!$message instanceof StampedMessage) {
            throw new RuntimeException(sprintf(
                'Message %s received stamps, but does not support them. Use HasStamps trait and implement StampedMessage interface.',
                $message::class
            ));
        }

        $message->addStamp(...$stamps);
    }
}
