<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Shared\Bus;

use App\System\MessageBus\Stamp\StampInterface;

interface StampedMessage
{
    public function addStamp(StampInterface ...$stamp): void;

    public function getStamp(string $stampClass): ?StampInterface;

    /** @return StampInterface[] */
    public function getStamps(): array;
}
