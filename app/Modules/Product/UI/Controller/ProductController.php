<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\UI\Controller;

use App\Modules\Product\Core\Application\Command\CreateProduct;
use App\Modules\Product\Core\Application\DTO\NewProductDTO;
use App\Modules\Product\Core\Application\Query\GetProduct;
use App\Modules\Shared\QueryBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Bus;
use Ramsey\Uuid\Uuid;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class ProductController extends Controller
{
    #[Post('products')]
    public function store(Request $request): JsonResponse
    {
        $dto = NewProductDTO::from($request->all());

        $command = new CreateProduct($dto);


        Bus::dispatch($command);

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
