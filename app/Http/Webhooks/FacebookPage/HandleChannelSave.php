<?php

namespace App\Http\Webhooks\FacebookPage;

use App\Models\Channel;
use App\Models\ServiceToken;
use Illuminate\Contracts\Auth\Authenticatable;

class HandleChannelSave
{
    /**
     * Handle the channel save.
     *
     * @param \App\Models\Channel $channel
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function execute(Channel $channel, Authenticatable $user)
    {
        $settings = $channel->settings[0] ?? $channel->settings;
        $settings = json_decode($settings['facebook_page'], true);
        $token = ServiceToken::where('token', $settings['access_token'])->first();

        if (! $token) {
            $token = new ServiceToken();
            $token->user_id = $user->id;
            $token->token = $settings['access_token'];
        }

        $token->service_id = $settings['id'];
        $token->name = $settings['name'];
        $token->service = $channel->type->name;

        $token->save();
    }
}
