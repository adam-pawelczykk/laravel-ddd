<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Application\Query;

use Ramsey\Uuid\UuidInterface;

readonly class GetProduct
{
    public function __construct(public UuidInterface $uuid)
    {
    }
}
