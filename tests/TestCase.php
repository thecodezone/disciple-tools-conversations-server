<?php

namespace Tests;

use GuzzleHttp\Psr7\Stream;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery\MockInterface;
use Psr\Http\Message\ResponseInterface;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    /**
     * Seed the database
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    protected function mockGuzzleResponse($body)
    {
        return \Mockery::mock(ResponseInterface::class, function (MockInterface $mock) use ($body) {
            return $mock->shouldReceive('getBody')->once()->andReturn(
                \Mockery::mock(Stream::class, function (MockInterface $mock) use ($body) {
                    return $mock->shouldReceive('getContents')->once()->andReturn($body);
                })
            );
        });
    }
}
