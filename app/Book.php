<?php

declare(strict_types=1);

namespace Hukimato\EsApp;

use Elastic\Elasticsearch\ClientBuilder;

class Book
{
    public static function find(array $params): array
    {
        $client = static::getDbClient();
        $query = (new QueryBuilder(minPrice: $params['min-price'], maxPrice: $params['max-price'], title: $params['title'], category: $params['category']))->getQuery();
        $results = $client->search($query);
        return $results['hits']['hits'];
    }

    protected static function getDbClient()
    {
        return ClientBuilder::create()
            ->setHosts(['https://elasticsearch:9200'])
            ->setBasicAuthentication('elastic', 'a2+t7Skc0A*cv5Gsb4Sg')
            ->setSSLVerification(false)
            ->build();
    }
}
