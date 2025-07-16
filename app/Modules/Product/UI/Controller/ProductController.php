<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\UI\Controller;

use App\Modules\Product\Core\Application\Command\CreateProduct;
use App\Modules\Product\Core\Application\DTO\NewProductDTO;
use App\Modules\Product\Core\Application\Query\GetProduct;
use App\Modules\Shared\Bus\CommandBus;
use App\Modules\Shared\Bus\QueryBus;
use App\System\MessageBus\Stamp\UserStamp;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Ramsey\Uuid\Uuid;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class ProductController extends Controller
{
    #[Post('products')]
    public function store(NewProductDTO $dto, CommandBus $commandBus): JsonResponse
    {
        $command = new CreateProduct($dto);
        $commandBus->dispatch($command, [
            new UserStamp(Uuid::uuid4())
        ]);

        return response()->json([
            'uuid' => $command->getUuid()
        ], 201);
    }

    #[Get('products/{uuid}')]
    public function show(string $uuid, QueryBus $queryBus): JsonResponse
    {
        $query = new GetProduct(Uuid::fromString($uuid));
        $product = $queryBus->query($query);

        return response()->json($product);
    }
}
