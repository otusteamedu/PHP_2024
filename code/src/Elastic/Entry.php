<?php

namespace  Otus\App\Elastic;

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
            ->setHosts(["https://$config->host:$config->port"])
            ->setBasicAuthentication($config->userName, $config->password)
            ->setSSLVerification(false)
            ->build();
    }
}
