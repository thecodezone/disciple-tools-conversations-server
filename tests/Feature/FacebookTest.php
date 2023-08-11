<?php

namespace Tests\Feature;

use App\Clients\FacebookClient;
use App\Models\User;
use Mockery\MockInterface;
use Tests\TestCase;

class FacebookTest extends TestCase
{
    /**
     * @test
     */
    public function it_fetches_user(): void
    {
        $user = User::factory()->admin()->withFacebookPageComments()->create();
        $instance = $user->instances->first();
        $service = $instance->services->first();
        $channel = $service->channels->first();
        $fixture = file_get_contents(__DIR__ . '/../fixtures/facebook_user.json');
        $this->actingAs(
            $user
        );


        $this->instance(
            FacebookClient::class,
            \Mockery::mock(FacebookClient::class, function (MockInterface $mock) use ($fixture) {
                $mock->shouldReceive('get')->once()->andReturn(
                    $this->mockGuzzleResponse($fixture)
                );
            })
        );

        $fixture = json_decode($fixture, true);


        $id = 'some-fake-id';

        $response = $this->get(route(
            'api.channel.user',
            [
                'channel' => $channel->id,
                'serviceUserId' => $id,
            ]
        ));

        $response
            ->assertJsonFragment([
                'id' => (int) $fixture['id'],
                'first_name' => $fixture['first_name'],
                'last_name' => $fixture['last_name'],
                'name' => $fixture['name'],
            ])
            ->assertStatus(200);
    }
}
