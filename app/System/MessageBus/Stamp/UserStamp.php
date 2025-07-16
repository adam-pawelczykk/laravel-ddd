<?php
/** @author: Adam Pawełczyk */

namespace App\System\MessageBus\Stamp;

use Ramsey\Uuid\UuidInterface;

readonly class UserStamp implements StampInterface
{
    public function __construct(public UuidInterface $userUuid)
    {
    }
}
