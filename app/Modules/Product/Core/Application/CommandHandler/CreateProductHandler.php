<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Application\CommandHandler;

use App\Modules\Product\Core\Application\Command\CreateProduct;
use App\Modules\Product\Core\Application\Event\ProductWasCreated;
use App\Modules\Product\Core\Domain\Product;
use App\Modules\Product\Core\Domain\ProductRepository;

readonly class CreateProductHandler
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function __invoke(CreateProduct $command): void
    {
        $product = new Product(
            $command->getUuid(),
            $command->getDto()->name,
            $command->getDto()->description,
            $command->getDto()->price,
            $command->getDto()->tags
        );

        $this->productRepository->add($product);

        // Dispatch an event after product creation
        event(new ProductWasCreated($product->getUuid()));
    }
}
