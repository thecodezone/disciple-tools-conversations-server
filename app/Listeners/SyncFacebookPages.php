<?php

namespace App\Listeners;

use App\Events\OAuthSuccess;
use App\Models\Service;
use App\Models\ServiceToken;
use App\Models\ServiceType;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SyncFacebookPages
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
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
        $userToken = $user->serviceTokens()->where('service', 'facebook')->first();

        if (!$userToken) {
            abort(401, 'Facebook is not connected.');
        }

        $client = new Client([
            'base_uri' => 'https://graph.facebook.com/',
        ]);
        $response = $client->get($userToken->service_id . '/accounts', [
            'query' => [
                'fields' => 'id,name,access_token',
                'access_token' => $userToken->token,
            ],
        ])->getBody()->getContents();
        $pageTokens = json_decode($response, true);

        foreach ($pageTokens['data'] as $pageToken) {
            ServiceToken::updateOrCreate([
                'owner_id' => $user->id,
                'owner_type' => $user::class,
                'service' => 'facebook_page',
                'service_id' => $pageToken['id'],
            ], [
                'token' => $pageToken['access_token']
            ]);
        }
    }
}
