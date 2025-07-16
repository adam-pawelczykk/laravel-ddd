<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Application\CommandHandler;

use App\Modules\Product\Core\Application\Command\CreateProduct;
use App\Modules\Product\Core\Application\Event\ProductWasCreated;
use App\Modules\Product\Core\Domain\Product;
use App\Modules\Product\Core\Domain\ProductRepository;
use App\Modules\Shared\Bus\EventBus;
use App\System\MessageBus\Stamp\UserStamp;
use Ramsey\Uuid\Uuid;

readonly class CreateProductHandler
{
    public function __construct(
        private ProductRepository $productRepository,
        private EventBus          $eventBus
    ) {
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
        $this->eventBus->dispatch(
            new ProductWasCreated($product->getUuid()),
            [
                new UserStamp(Uuid::uuid4())
            ]
        );
    }
}
