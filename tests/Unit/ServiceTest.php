<?php

namespace Tests\Unit;

use App\Models\Service;
use Tests\TestCase;

/**
 * Class ServiceTest
 * @group services
 */
class ServiceTest extends TestCase
{
    /**
     * Test that the service model can be transformed to a service driver.
     * @return void
     */
    public function test_service_driver_resolves(): void
    {
        $service = Service::factory()->create(
            [
                'type' => 'facebook_messenger'
            ]
        );
        $driver = $service->driver();
        $this->assertInstanceOf(\App\Services\FacebookMessenger::class, $driver);
    }
}
