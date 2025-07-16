<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Shared\Traits;

use App\System\MessageBus\Stamp\StampInterface;

trait HasStamps
{
    /** @var StampInterface[] */
    private array $stamps = [];

    public function addStamp(StampInterface ...$stamps): void
    {
        foreach ($stamps as $stamp) {
            $this->stamps[] = $stamp;
        }
    }

    /**
     * @template T of StampInterface
     * @param class-string<T> $stampClass
     * @return T|null
     */
    public function getStamp(string $stampClass): ?StampInterface
    {
        foreach ($this->stamps as $stamp) {
            if ($stamp instanceof $stampClass) {
                return $stamp;
            }
        }

        return null;
    }

    /** @return StampInterface[] */
    public function getStamps(): array
    {
        return $this->stamps;
    }
}
