<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Shared\Traits;

trait HasDomainEvents
{
    /** @var array<object> */
    private array $recordedEvents = [];

    public function recordEvent(object $event): void
    {
        $this->recordedEvents[] = $event;
    }

    /** @return array<object> */
    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];

        return $events;
    }

    /** @return bool */
    public function hasEvents(): bool
    {
        return !empty($this->recordedEvents);
    }
}
