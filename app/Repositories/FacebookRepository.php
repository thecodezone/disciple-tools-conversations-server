<?php

namespace App\Repositories;

use App\Data\User;
use App\Sdks\FacebookSdk;

class FacebookRepository implements ChannelRepository
{
    private $sdk;

    public function __construct(FacebookSdk $sdk)
    {
        $this->sdk = $sdk;
    }

    public function getUser($channel, $id): User|null
    {
        $response = $this->sdk->getUser(
            $channel->service->token,
            $id
        );

        if (! $response) {
            return null;
        }

        return User::from([
            'id' => $response['id'],
            'first_name' => $response['first_name'],
            'last_name' => $response['last_name'],
            'name' => $response['name']
        ]);
    }
}
