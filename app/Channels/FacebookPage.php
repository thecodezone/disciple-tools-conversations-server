<?php

namespace App\Channels;

use App\Data\Message;
use App\Data\Webhook;
use App\Events\OAuthSuccess;
use App\Listeners\SyncFacebookPages;
use App\Models\ServiceToken;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Filament\Forms\Components\Select;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\DataCollection;

class FacebookPage implements Channel {
    public static function register(): void {
        Event::listen(OAuthSuccess::class, [ SyncFacebookPages::class ]);
    }

    public function settingsFields(): array
    {
        $pages = ServiceToken::all();

        return [
            Select::make('facebook_page')
                  ->options($pages->pluck('name', 'id')->toArray())
                  ->required(),
        ];
    }

    public function getPageToken( \App\Models\Channel $channel ): ?ServiceToken
    {
        $serviceTokenId = $channel->settings ?? null;
        if (!$serviceTokenId) {
            return null;
        }
        return ServiceToken::find($serviceTokenId)->first();
    }

    public function connected( \App\Models\Channel $channel ): bool
    {
        $pageToken = $this->getPageToken($channel);
        if (!$pageToken) {
            return false;
        }
        return $pageToken->active;
    }

    public function transformMessage(\App\Models\Channel $channel, $change): Message {
        return Message::from([
            'webhook_id' => $change["post_id"],
            'webhook_type' => $change["item"],
            'message' => $change['message'],
            'receivedAt' => Carbon::createFromTimestamp($change['created_time']),
            'from_id' => $change['from']['id'],
            'from_name' => $change['from']['name']
        ]);
    }

    public function transform(\App\Models\Channel $channel, Request $request) {
        return Webhook::from([
            'channel' => 'facebook',
            'channel_id' => $channel->id,
            'service' => 'facebook',
            'service_id' => $channel->service_id,
            'provider' => 'facebook',
            'provider_id' => $channel->provider_id,
            'messages' => Message::collection(array_map(function ($change) use ($channel) {
                return $this->transformMessage($channel, $change);
            }, $request->input('entry.0.changes', []))),
            'raw' => $request->all(),
        ]);
    }

    public function verifyRequest( \App\Models\Channel $channel, Request $request ): bool {
        //Check if GET request
        if ($request->method() !== 'GET') {
            if ($channel->verification_token !== $request->input('hub_verify_token')) {
                abort(401, 'Invalid verification token.');
            }

            return true;
        }

        $signature = $request->header('X-Hub-Signature-256');
        $payload = $request->getContent();
        $secret = $channel->token->secret;
        $hashed = hash('sha256', $payload, $secret);

        return $signature === $hashed;
    }

    public function handleChallengeRequest( \App\Models\Channel $channel, Request $request ): Response {
        return response($request->input('hub_challenge'));
    }

    public function handleWebhookRequest( \App\Models\Channel $channel, Request $request ): Response {
        $this->send($channel, $request);
        return response()->noContent(200);
    }

    public function send(\App\Models\Channel $channel, Request $request) {
        $instance = $channel->instance;
        $client = new \GuzzleHttp\Client([
            'base_uri' => $instance->endpoint,
        ]);
        $client->post('messages/webhook', [
            'query' => [
                'verify_token' => $instance->verification_token,
            ],
            'json' => $this->transform($channel, $request)
        ]);
    }
}
