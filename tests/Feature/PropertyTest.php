<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use App\Models\Property;
use Tests\TestCase;
use Str;

class PropertyTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCanCreateAProperty()
    {
        // post the data to the properties store method
        $response = $this->post(route('properties.store'), [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 10, 20),
            'type' => 'flat',
        ]);

        $response->assertSuccessful()
        ->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure([
            'success', 'data', 'message'
        ]);
    }

    public function testInvalidDataCanNotCreateAProperty()
    {
        // post the data to the properties store method
        $response = $this->post(route('properties.store'), [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 10, 20),
        ]);

        $response->assertUnprocessable()
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'type'
            ]
        ]);
    }

    public function testCanGetPaginatedListOfProperties()
    {
        // Create 20 Properties in the database
        Property::factory()->count(20)->create();

        // Get all Properties (Paginated)
        $response = $this->get(route('properties.index'));
        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'uuid',
                    'name',
                    'price',
                    'type',
                ]
            ],
            'metadata' => [
                "total_count",
                "chunk_count",
                "page_count",
                "page",
                "limit",
                "order",
            ]
        ]);
    }

    public function testCanGetASingleProperty()
    {
        $property = Property::factory()->create();
        $response = $this->get(route('properties.show', $property['uuid']));
        $response->assertSuccessful();

        $response->assertJson([
            'data' => [
                'uuid' => $property['uuid'],
                'name' => $property['name'],
                'price' => $property['price'],
                'type' => $property['type']
            ]
        ])->assertJsonStructure([
            'success', 'data', 'message'
        ]);
    }

    public function testInvalidDataCanNotGetASingleProperty()
    {
        $property = Property::factory()->create();
        $response = $this->get(route('properties.show', 500));

        $response->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertJsonStructure([
            'success', 'message'
        ]);
    }

    public function testCanUpdateAProperty()
    {
        $property = property::factory()->create();

        $response = $this->patch(route('properties.update', $property['uuid']), [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 10, 20),
            'type' => 'detached-house',
        ]);

        $response->assertSuccessful()
        ->assertJsonStructure([
            'success', 'message'
        ]);
    }

    public function testInvalidPropertyIdCanNotUpdateAProperty()
    {
        $property = property::factory()->create();

        $response = $this->patch(route('properties.update', 500), [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 10, 20),
            'type' => 'detached-house',
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertJsonStructure([
            'success', 'message'
        ]);
    }

    public function testInvalidDataCanNotUpdateAProperty()
    {
        $property = property::factory()->create();

        $response = $this->patch(route('properties.update', $property['uuid']), [
            'name' => $this->faker->name,
            'type' => 'detached-house',
        ]);
        $response->assertUnprocessable()
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCanDeleteAProperty()
    {
        $property = property::factory()->create();
        $response = $this->delete(route('properties.destroy', $property['uuid']));
        $response->assertSuccessful()
        ->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testInvalidPropertyIdCanNotDeleteAProperty()
    {
        $property = property::factory()->create();
        $response = $this->delete(route('properties.destroy', 500));

        $response->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertJsonStructure([
            'success', 'message'
        ]);
    }
}
