<?php

namespace App\Profiles;

use App\Models\Channel;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookProfile\WebhookProfile;

class DriverProfile implements WebhookProfile
{

    public function shouldProcess(Request $request): bool
    {
        $channelId = $request->route('channel');
        if (! $channelId || ! $channel = Channel::find($channelId)) {
            return false;
        }
        $driver = $channel->driver();
        return $driver->shouldProcess($channel, $request);
    }
}
