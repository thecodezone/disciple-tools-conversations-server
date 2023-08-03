<?php

namespace App\SignatureValidators;

use App\Models\Channel;
use Illuminate\Http\Request;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class DriverSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $channelId = $request->route('channel');
        if (! $channelId || ! $channel = Channel::find($channelId)) {
            return false;
        }
        $driver = $channel->driver();
        return $driver->isValid($channel, $request);
    }
}
