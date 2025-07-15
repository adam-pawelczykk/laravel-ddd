<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Application\Command;

use App\Modules\Product\Core\Application\DTO\NewProductDTO;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CreateProduct
{
    private UuidInterface $uuid;

    public function __construct(
        private readonly NewProductDTO $dto,
        ?UuidInterface                 $uuid = null
    ) {
        $this->uuid = $uuid ?? Uuid::uuid4();
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getDto(): NewProductDTO
    {
        return $this->dto;
    }
}
