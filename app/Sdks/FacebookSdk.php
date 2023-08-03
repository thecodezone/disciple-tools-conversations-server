<?php

namespace App\Sdks;

use App\Clients\FacebookClient;
use App\Data\MessageWebhook;
use App\Models\Instance;
use App\Models\ServiceToken;
use Illuminate\Support\Facades\Cache;

class FacebookSdk
{
    protected $client;

    public function __construct(FacebookClient $client)
    {
        $this->client = $client;
    }

    public function get($token, $endpoint, $query = []): array
    {
        $response = $this->client->get($endpoint, [
            'query' => array_merge($query, [
                'access_token' => $token,
            ]),
        ])->getBody()->getContents();

        return json_decode($response, true);
    }

    /**
     * Get all the accounts for a user
     * e.g. facebook pages
     *
     * @param \App\Models\ServiceToken $token
     * @param $query
     * @return array
     *
     * @todo REMOVE FAKE DATA
     */
    public function getAccounts(ServiceToken $token, $query = [
        'fields' => 'id,name,access_token',
    ]): array
    {
        $result = Cache::remember('users', 60 * 60, function () use ($token, $query) {
            return $this->get($token->token, $token->service_id . '/accounts', $query);
        });

        if (! count($result['data'])) {
            $result['data'] = [
                [
                    'name' => 'Facebook Page 1',
                    'access_token' => 'PAGE-1-ACCESS-TOKEN',
                    'id' => 'PAGE-1-ID'
                ],
                [
                    'name' => 'Facebook Page 2',
                    'access_token' => 'PAGE-2-ACCESS-TOKEN',
                    'id' => 'PAGE-2-ID'
                ],
                [
                    'name' => 'Facebook Page 3',
                    'access_token' => 'PAGE-3-ACCESS-TOKEN',
                    'id' => 'PAGE-3-ID'
                ],
            ];
        }
        return $result;
    }

    public function sendWebhook(Instance $instance, MessageWebhook $webhook): array
    {
        throw new \Exception('Not implemented');
    }
}
