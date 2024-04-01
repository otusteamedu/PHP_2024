<?php

declare(strict_types=1);

namespace Pozys\OtusShop\Elastic;

use Elastic\Elasticsearch\{Client, ClientBuilder};

class Connection
{
    private Client $client;

    public function __construct()
    {
        $host = getenv('ELASTIC_HOST');
        $port = getenv('ELASTIC_PORT');
        $this->client = ClientBuilder::create()
            ->setHosts(["https://$host:$port"])
            ->setBasicAuthentication(getenv('ELASTIC_USER'), getenv('ELASTIC_PASSWORD'))
            ->setCABundle(getenv('ELASTIC_CA_BUNDLE'))
            ->build();
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
