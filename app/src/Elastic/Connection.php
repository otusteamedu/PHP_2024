<?php

declare(strict_types=1);

namespace AnatolyShilyaev\App\Elastic;

use Elastic\Elasticsearch\Client;
use AnatolyShilyaev\App\Elastic\Config;
use Elastic\Elasticsearch\ClientBuilder;

class Connection
{
    public Client $client;

    public function __construct()
    {
        $config = new Config();
        $this->client = ClientBuilder::create()
            ->setHosts(["https://$config->host:$config->port"])
            ->setBasicAuthentication($config->userName, $config->password)
            ->setSSLVerification(false)
            ->build();
    }
}
