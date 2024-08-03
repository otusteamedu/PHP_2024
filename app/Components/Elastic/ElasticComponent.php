<?php

namespace App\Components\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

readonly class ElasticComponent
{
    public Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $config = require_once 'config.php';

        $this->client = ClientBuilder::create()
            ->setBasicAuthentication($config['username'], $config['password'])
            ->build();
    }
}