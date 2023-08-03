<?php

namespace App\Http\Webhooks;

use App\Models\Channel;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

interface WebhookTransformer
{
    /**
     * Transform the payload into an array of webhooks.
     */
    public function transform(Channel $channel, $payload): DataCollection|Data;
}
