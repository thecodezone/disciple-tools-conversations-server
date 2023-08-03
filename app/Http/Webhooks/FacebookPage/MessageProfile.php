<?php

namespace App\Http\Webhooks\FacebookPage;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookProfile\WebhookProfile;

class MessageProfile implements WebhookProfile
{
    /**
     * Should the webhook be processed?
     *
     * @param \App\Models\Channel $channel
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function shouldProcess(Request $request): bool
    {
        if (! $request->input('object') === 'page' || ! $request->has('entry')) {
            return false;
        }

        if (! is_array($request->input('entry'))) {
            return false;
        }

        return true;
    }
}
