<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Application\Event;

use Ramsey\Uuid\UuidInterface;

readonly class ProductWasCreated
{
    public function __construct(private UuidInterface $productUuid)
    {
    }

    public function getProductUuid(): UuidInterface
    {
        return $this->productUuid;
    }
}
