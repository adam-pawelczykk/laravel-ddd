<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Infrastructure\Repository;

use App\Modules\Product\Core\Domain\Product;
use App\Modules\Product\Core\Domain\ProductRepository;
use Ramsey\Uuid\UuidInterface;

class InMemoryProductRepository implements ProductRepository
{
    /** @var Product[] */
    private array $products = [];

    public function add(Product $product): void
    {
        $this->products[(string) $product->getUuid()] = $product;
    }

    public function find(UuidInterface $uuid): ?Product
    {
        return $this->products[(string) $uuid] ?? null;
    }
}
