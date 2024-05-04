<?php

namespace Ahar\Hw11;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class Elastic
{
    public function __construct(
        private readonly ElasticConfig $config
    )
    {
    }

    public function buildCClient(): Client
    {
        return ClientBuilder::create()
            ->setHosts([$this->config->getHost()])
            ->setSSLVerification(false)
            ->setBasicAuthentication($this->config->getUser(), $this->config->getPassword())
            ->build();
    }
}
