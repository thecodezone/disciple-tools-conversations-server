<?php

namespace App\Clients;

use GuzzleHttp\Client;

class FacebookClient extends Client
{

    public function __construct(array $config = [])
    {
        parent::__construct(
            array_merge([
                'base_uri' => 'https://graph.facebook.com/',
            ], $config)
        );
    }
}
