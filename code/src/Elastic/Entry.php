<?php

declare(strict_types=1);

namespace OtusElasticShop\App\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class Entry
{
    public Client $client;
    public Config $config;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $config = new Config();
        $this->config = $config;

        $this->client = ClientBuilder::create()
            ->setHosts(['https://' . $this->config->host . ':' . $this->config->port])
            ->setApiKey($this->config->apiKey)
            ->build();
    }
}
