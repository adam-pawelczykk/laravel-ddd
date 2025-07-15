<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Product\Core\Domain\ProductRepository;
use App\Modules\Product\Core\Infrastructure\Repository\EloquentProductRepository;

class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind repository interface to implementation
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);
    }
}
