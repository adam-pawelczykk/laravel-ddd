<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Domain;

use Ramsey\Uuid\UuidInterface;

interface ProductRepository
{
    public function add(Product $product): void;
    public function find(UuidInterface $uuid): ?Product;
}
