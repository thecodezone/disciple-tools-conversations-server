<?php

namespace App\Listeners;

use App\Events\OAuthSuccess;
use App\Models\ServiceToken;
use App\Sdks\FacebookSdk;

class SyncFacebookPages
{
    protected $facebookSdk;

    /**
     * Create the event listener.
     */
    public function __construct(FacebookSdk $facebookSdk)
    {
        $this->facebookSdk = $facebookSdk;
    }

    /**
     * Handle the event.
     */
    public function handle(OAuthSuccess $event): void
    {
        if ($event->serviceToken->service !== 'facebook') {
            return;
        }

        $user = $event->user;
        $serviceToken = $event->serviceToken;

        if (! $serviceToken) {
            abort(401, 'Facebook is not connected.');
        }

        $pageTokens = $this->facebookSdk->getAccounts($serviceToken);

        foreach ($pageTokens['data'] as $pageToken) {
            ServiceToken::updateOrCreate([
                'owner_id' => $user->id,
                'owner_type' => $user::class,
                'service' => 'facebook_page',
                'service_id' => $pageToken['id'],
            ], [
                'token' => $pageToken['access_token'],
            ]);
        }
    }
}
