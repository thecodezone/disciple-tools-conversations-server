<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function challenge(Channel $channel, Request $request) {
        $driver = $channel->driver();
        return $driver->handleChallengeRequest($channel, $request);
    }

    public function webhook(Channel $channel, Request $request) {
        $driver = $channel->driver();
        return $driver->handleWebhookRequest($channel, $request);
    }
}
