<?php

namespace App\Http\Webhooks\FacebookPage;

use App\Data\MessageWebhook;
use App\Http\Webhooks\WebhookTransformer;
use App\Models\Channel;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Spatie\LaravelData\DataCollection;

class MessageTransformer implements WebhookTransformer
{
    protected CommentProfile $profile;

    public function __construct(CommentProfile $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Transform the payload into a Webhook.
     *
     * Facebook sends multiple changes in a single webhook request,
     * so we are return a collection of webhooks to send.
     */
    public function transform(Channel $channel, $payload): DataCollection
    {
        return MessageWebhook::collection(array_map(function ($message) use ($channel, $payload) {
            return [
                'channel' => $channel->name,
                'channel_id' => $channel->id,
                'service' => $channel->service->name,
                'service_id' => $channel->service_id,
                'provider' => 'facebook',
                'provider_id' => $channel->provider_id,
                'parent_id' => Arr::get($payload, 'id'),
                'message_id' => Arr::get($message, 'message.mid'),
                'message' => Arr::get($message, 'message.text'),
                'verb' => 'add',
                'received_at' => Arr::has($message, 'timestamp') ? Carbon::createFromTimestamp($message['timestamp']) : null,
                'from_id' => Arr::get($message, 'sender.id'),
                'from_name' => Arr::get($message, 'sender.name'),
                'link' => null
            ];
        }, Arr::get($payload, 'entry.messaging')));
    }
}
