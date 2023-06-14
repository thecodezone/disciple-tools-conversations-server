<?php

namespace Tests\Feature;

use App\Models\Instance;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @group services
 */
class ServiceTest extends TestCase
{
    /**
     * Test that the service index can be retrieved
     */
    public function test_it_gets_service_index(): void
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $count = fake()->numberBetween(1, 10);
        $instance = Instance::factory()->hasServices($count)->create();
        $instance->users()->sync([$user->id]);
        $response = $this->get(route('api.instances.services.index', $instance->id));
        $response->assertStatus(200);
        $response->assertJsonCount($count, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'type',
                    'access_token',
                    'created_at',
                ]
            ]
        ]);
    }

    /**
     * Test that unowned services can not be fetched
     */
    public function test_it_cannot_get_unowned_service_index(): void
    {
        $me = User::factory()->admin()->create();
        $user = User::factory()->admin()->create();
        $count = fake()->numberBetween(1, 10);
        $instance = Instance::factory()->hasServices($count)->create();
        $instance->users()->sync([$user->id]);

        $this->actingAs($me);
        $response = $this->get(route('api.instances.services.index', $instance->id));
        $response->assertStatus(403);
    }

    /**
     * Test that it cannot delete a service if not owned
     */
    public function test_it_cannot_delete_unowned_service(): void
    {
        $me = User::factory()->admin()->create();
        $user = User::factory()->admin()->create();
        $service = Service::factory()->create();
        $service->instance->users()->sync([$user->id]);

        $this->actingAs($me);
        $response = $this->delete(route('api.instances.services.destroy', [$service->instance_id, $service->id]));
        $response->assertStatus(403);
    }

    /**
     * Test tht it can delete a service
     */
    public function test_it_can_delete_a_service(): void {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $service = Service::factory()->create();
        $service->instance->users()->sync([$user->id]);
        $response = $this->delete(route('api.instances.services.destroy', [$service->instance_id, $service->id]));
        $response->assertStatus(204);
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

}
