<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Application\QueryHandler;

use App\Modules\Product\Core\Application\Query\GetProduct;
use App\Modules\Product\Core\Domain\Product;
use App\Modules\Product\Core\Domain\ProductRepository;

readonly class GetProductHandler
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function __invoke(GetProduct $query): ?Product
    {
        return $this->repository->find($query->uuid);
    }
}
