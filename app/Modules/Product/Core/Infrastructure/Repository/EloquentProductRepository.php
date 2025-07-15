<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Infrastructure\Repository;

use App\Modules\Product\Core\Domain\Product;
use App\Modules\Product\Core\Domain\ProductRepository;
use App\Modules\Product\Core\Infrastructure\Eloquent\ProductModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class EloquentProductRepository
 * @package App\Modules\Product\Core\Infrastructure\Repository
 */
class EloquentProductRepository implements ProductRepository
{
    public function add(Product $product): void
    {
        ProductModel::create([
            'uuid' => $product->getUuid(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'tags' => $product->getTags(),
        ]);
    }

    public function find(UuidInterface $uuid): ?Product
    {
        $model = ProductModel::where('uuid', $uuid)->first();

        if (! $model instanceof ProductModel) {
            return null;
        }

        return $this->mapToDomain($model);
    }

    private function mapToDomain(ProductModel $model): Product
    {
        return new Product(
            Uuid::fromString($model->uuid),
            $model->name,
            $model->description,
            $model->price,
            $model->tags
        );
    }
}
