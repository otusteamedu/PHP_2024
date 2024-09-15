<?php

namespace  Otus\App\Elastic;

use Elastic\Elasticsearch\ClientBuilder;

class Entry
{
    public \Elastic\Elasticsearch\Client $client;
    public Config $config;

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
