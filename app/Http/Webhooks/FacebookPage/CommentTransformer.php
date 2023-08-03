<?php

namespace App\Http\Webhooks\FacebookPage;

use App\Data\MessageWebhook;
use App\Http\Webhooks\WebhookTransformer;
use App\Models\Channel;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Spatie\LaravelData\DataCollection;

class CommentTransformer implements WebhookTransformer
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
        return MessageWebhook::collection(
            Arr::get($payload, 'entry.changes')
                ->map(function ($change) use ($channel, $payload) {
                    return [
                        'channel' => $channel->name,
                        'channel_id' => $channel->id,
                        'service' => $channel->service->name,
                        'service_id' => $channel->service_id,
                        'provider' => 'facebook',
                        'provider_id' => $channel->provider_id,
                        'post_id' => Arr::get($payload, 'post_id'),
                        'post_url' => Arr::get($change, 'post.permalink_url'),
                        'post_type' => Arr::get($change, 'post.type'),
                        'message_id' => Arr::get($change, 'post_id'),
                        'message' => Arr::get($change, 'message'),
                        'verb' => Arr::get($this->profile->verbs, Arr::get($change, 'verb')),
                        'posted_at' => Arr::has($change, 'created_time')
                            ? Carbon::createFromTimestamp($change['created_time']) : null,
                        'from_id' => Arr::get($change, 'from.id'),
                        'from_name' => Arr::get($change, 'from.name'),
                        'link' => Arr::get($change, 'link')
                    ];
                })
        );
    }
}
