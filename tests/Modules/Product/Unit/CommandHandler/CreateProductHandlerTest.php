<?php

/** @author: Adam Pawełczyk */

namespace Modules\Product\Unit\CommandHandler;

use App\Modules\Product\Core\Application\Command\CreateProduct;
use App\Modules\Product\Core\Application\CommandHandler\CreateProductHandler;
use App\Modules\Product\Core\Application\DTO\NewProductDTO;
use App\Modules\Product\Core\Application\Event\ProductWasCreated;
use App\Modules\Product\Core\Infrastructure\Repository\InMemoryProductRepository;
use Ramsey\Uuid\Uuid;
use Tests\UnitTestCase;
use Tests\Utils\InMemoryMessageBus;

class CreateProductHandlerTest extends UnitTestCase
{
    private InMemoryProductRepository $repository;
    private InMemoryMessageBus $eventBus;
    private CreateProductHandler $SUT;

    protected function setUp(): void
    {
        $this->SUT = new CreateProductHandler(
            $this->repository = new InMemoryProductRepository(),
            $this->eventBus = new InMemoryMessageBus()
        );
    }

    public function testShouldSuccessCreateNewProduct(): void
    {
        // Given
        $dto = new NewProductDTO(
            name: 'Test Product',
            description: 'Some description',
            price: 99.99,
            tags: ['tag1', 'tag2']
        );

        // When
        $SUT = $this->SUT;
        $SUT($command = new CreateProduct($dto, Uuid::uuid4()));

        // Then
        $product = $this->repository->find($command->getUuid());

        $this->assertNotNull($product);
        $this->assertEquals($dto->name, $product->getName());
        $this->assertEquals($dto->description, $product->getDescription());
        $this->assertEquals($dto->price, $product->getPrice());
        $this->assertEquals($dto->tags, $product->getTags());

        $event = $this->eventBus->getLastMessageByClass(ProductWasCreated::class);

        $this->assertNotNull($event);
        $this->assertEquals($command->getUuid(), $event->getProductUuid());
    }
}
