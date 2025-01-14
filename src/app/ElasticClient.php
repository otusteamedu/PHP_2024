<?php

declare(strict_types=1);

namespace App;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class ElasticClient
{
    private Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()->setSSLVerification(false)->build();
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
