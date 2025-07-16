<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Application\Event;

use App\Modules\Shared\Bus\StampedMessage;
use App\Modules\Shared\Traits\HasStamps;
use Ramsey\Uuid\UuidInterface;

class ProductWasCreated implements StampedMessage
{
    use HasStamps;

    public function __construct(private readonly UuidInterface $productUuid)
    {
    }

    public function getProductUuid(): UuidInterface
    {
        return $this->productUuid;
    }
}
