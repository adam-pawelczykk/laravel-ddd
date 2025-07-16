<?php

/** @author: Adam Pawełczyk */

namespace Tests\Modules\Product\Feature;

use App\Modules\Product\Core\Domain\Product;
use App\Modules\Product\Core\Domain\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\KernelTestCase;

class CreateProductKernelTest extends KernelTestCase
{
    use RefreshDatabase;

    public function testShouldSuccessCreateNewProduct(): void
    {
        // Given
        $payload = [
            'name' => 'Test Product',
            'description' => 'Some description',
            'price' => 99.99,
            'tags' => ['tag1', 'tag2'],
        ];

        // When
        $response = $this->postJson('/products', $payload);

        // Then
        $response->assertStatus(201);
        $response->assertJsonStructure(['uuid']);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 99.99,
        ]);
    }

    public function testShouldReturnValidationErrorWhenPayloadIsIncomplete(): void
    {
        // Given
        $payload = [
            'description' => 'Some description',
            'price' => 99.99,
            'tags' => ['tag1', 'tag2'],
        ];

        // When
        $response = $this->postJson('/products', $payload);

        // Then
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function testShouldSuccessReturnProduct(): void
    {
        // Given
        $product = new Product(
            uuid: Uuid::uuid4(),
            name: 'Test Product',
            description: 'Some description',
            price: 99.99,
            tags: ['tag1', 'tag2']
        );

        $repository = $this->app->make(ProductRepository::class);
        $repository->add($product);

        // When
        $response = $this->getJson('/products/' . $product->getUuid()->toString());

        // Then
        $response->assertStatus(200);
    }
}
