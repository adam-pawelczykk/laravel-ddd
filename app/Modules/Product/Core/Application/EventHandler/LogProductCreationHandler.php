<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Application\EventHandler;

use App\Modules\Product\Core\Application\Event\ProductWasCreated;
use App\Modules\Product\Core\Domain\ProductRepository;
use Illuminate\Support\Facades\Log;

readonly class LogProductCreationHandler
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function __invoke(ProductWasCreated $event): void
    {
        $product = $this->productRepository->find($event->getProductUuid());

        Log::info('New product was created', [
            'uuid' => (string)$product->getUuid(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'tags' => $product->getTags(),
        ]);
    }
}
