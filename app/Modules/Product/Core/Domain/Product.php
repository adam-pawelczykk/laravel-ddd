<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Domain;

use Ramsey\Uuid\UuidInterface;

class Product
{
    public function __construct(
        private readonly UuidInterface $uuid,
        private string                 $name,
        private ?string                $description,
        private float                  $price,
        private ?array                 $tags = []
    ) {
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): void
    {
        $this->tags = $tags;
    }
}
