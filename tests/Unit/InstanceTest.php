<?php

namespace Tests\Unit;

use App\Models\Instance;
use Tests\TestCase;

class InstanceTest extends TestCase
{
    public function test_generates_verification_tokens(): void
    {
        $factory = Instance::factory([
            'verification_token' => null
        ])->create();

        $this->assertNotNull($factory->verification_token);
    }
}
