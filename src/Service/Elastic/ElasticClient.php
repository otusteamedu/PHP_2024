<?php

namespace KRudenko\Otus\Service\Elastic;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticClient
{
    public static function getClient()
    {
        return ClientBuilder::create()
            ->setHosts([$_ENV['ELASTICSEARCH_HOST']])
            ->setBasicAuthentication($_ENV['ELASTICSEARCH_USER'], $_ENV['ELASTICSEARCH_PASSWORD'])
            ->setCABundle($_ENV['ELASTICSEARCH_CA_BUNDLE'])
            ->build();
    }
}
