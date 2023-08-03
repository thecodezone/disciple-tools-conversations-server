<?php

namespace Tests\Feature;

use App\Models\Channel;
use Tests\TestCase;

/**
 * @group facebook
 * @group webhooks
 */
class FacebookWebhookTest extends TestCase
{
    public function test_challenge()
    {
        $channel = Channel::factory()->facebookPage()->create();
        $challenge = fake()->uuid;
        $this->get(route('channels.challenge', [
            'channel' => $channel,
            'hob_mode' => 'subscribe',
            'hub_challenge' => $challenge,
            'hub_verify_token' => $channel->verify_token,
        ]))
            ->assertStatus(200)
            ->assertSee($challenge);
    }

    public function test_verification()
    {
        $channel = Channel::factory()->facebookPage()->create();
        $challenge = fake()->uuid;
        $this->get(route('channels.challenge', [
            'channel' => $channel,
            'hob_mode' => 'subscribe',
            'hub_challenge' => $challenge,
            'hub_verify_token' => 'wrong',
        ]))
            ->assertStatus(401);
    }

    public function test_webhook()
    {
        $json = file_get_contents(__DIR__ . '/../fixtures/facebook_page_webhook.json');
        $channel = Channel::factory()->facebookPage()->create();
        $secret = $channel->service->token->secret;
        $signature = hash('sha256', $json, $secret);
        $endpoint = route('channels.webhook', $channel->id, false);

        $this->call(
            'POST',
            $endpoint,
            [],
            [],
            [],
            [
                'X-Facebook-Webhook-Secret' => $secret,
            ],
            $json = json_encode(['foo' => 'bar'])
        )->assertStatus(200);
    }
}
