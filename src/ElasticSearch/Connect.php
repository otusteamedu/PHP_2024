<?php

namespace VladimirGrinko\ElasticSearch;

class Connect
{
    private $es;

    public function __construct()
    {
        $this->es = \Elastic\Elasticsearch\ClientBuilder::create()
            ->setHosts([getenv('ES_HOST')])
            ->setBasicAuthentication(getenv('ELASTIC_LOGIN'), getenv('ELASTIC_PASSWORD'))
            ->setCABundle(getenv('SRT_PATH'))
            ->build();
    }

    public function getClient(): \Elastic\Elasticsearch\Client
    {
        return $this->es;
    }
}
