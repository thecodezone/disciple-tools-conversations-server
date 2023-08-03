<?php

namespace App\Http\Webhooks\FacebookPage;

use App\Jobs\SendWebhook;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookResponse\RespondsToWebhook;
use Symfony\Component\HttpFoundation\Response;

class CommentResponse implements RespondsToWebhook
{
    /**
     * The transformer instance.
     */
    protected CommentTransformer $transformer;

    /**
     * The profile instance.
     */
    protected CommentProfile $profile;

    public function __construct(CommentTransformer $transformer, CommentProfile $profile)
    {
        $this->transformer = $transformer;
        $this->profile = $profile;
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
        $entries = json_decode($request->getContent(), true);

        //Loop through each entry, make sure it's a page entry,
        //and then filter out any changes that aren't comments.
        $entries = $this->profile->filterEntries(collect($entries));

        $entries->each(function ($entry) use ($channel) {
            $webhooks = $this->transformer->transform($channel, $entry);

            //Send each webhook in a separate job.
            $webhooks->each(function ($webhook) {
                SendWebhook::dispatch(
                    $webhook->channel,
                    $webhook
                );
            });
        });

        return response('OK', 200);
    }
}
