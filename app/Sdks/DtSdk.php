<?php

namespace App\Sdks;

use App\Data\MessageWebhook;
use App\Models\Instance;
use GuzzleHttp\Client;

/**
 * Makes requests to a DT instance.
 */
class DtSdk
{
    protected $instance;
    protected $client;
    protected $namespace = 'dt-conversations';
    protected $version = 'v1';
    protected $endpoint = '';

    /**
     * Build up the client a given instance.
     *
     * @param Instance $instance
     */
    public function __construct(Instance $instance)
    {
        $this->instance = $instance;
        $this->restBaseUrl = '/wp-json/' . $this->namespace . '/' . $this->version . '/';
        $this->client = new Client([
            'base_uri' => trim($instance->endpoint, '/'),
            'query' => [
                'verify_token' => $instance->verification_token,
            ],
        ]);
    }

    /**
     * Send a GET request to a DT endpoint.
     *
     * @param $endpoint
     * @param $query
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($endpoint, $query = []): array
    {
        $response = $this->client->get($endpoint, [
            'query' => $query,
        ])->getBody()->getContents();

        return json_decode($response, true);
    }

    /**
     * Send a POST request to a DT endpoint.
     *
     * @param $endpoint
     * @param $query
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($endpoint, $query = []): array
    {
        $response = $this->client->post($endpoint, [
            'query' => $query,
        ])->getBody()->getContents();

        return json_decode($response, true);
    }

    /**
     * Post a webhook message to a DT instance.
     *
     * @param Instance $instance
     * @param MessageWebhook $webhook
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postMessage(Instance $instance, MessageWebhook $webhook ): array {
        return $this->post($this->restBaseUrl . 'messages', [
            'json' => $webhook,
        ]);
    }
}
