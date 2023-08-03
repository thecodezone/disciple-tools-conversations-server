<?php

namespace App\Http\Webhooks\FacebookPage;

use App\Jobs\SendWebhook;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookResponse\RespondsToWebhook;
use Symfony\Component\HttpFoundation\Response;

class MessageResponse implements RespondsToWebhook
{
    /**
     * The transformer instance.
     */
    protected CommentTransformer $transformer;

    /**
     * The profile instance.
     */
    protected CommentProfile $profile;

    public function __construct(MessageTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Handle an incoming webhook from the service.
     * Most of the time we will want to transform
     * the webhook into a Message and send it to the channel instance.
     *
     * @param \App\Models\Channel $channel
     * @param \Illuminate\Http\Request $request
     */
    public function respondToValidWebhook(Request $request, WebhookConfig $config): Response
    {
        $channel = $request->route('channel');
        $webhooks = $this->transformer->transform($channel, $request->input('entry'));

        //Send each webhook in a separate job.
        $webhooks->each(function ($webhook) {
            SendWebhook::dispatch(
                $webhook->channel,
                $webhook
            );
        });

        return response('OK', 200);
    }
}
