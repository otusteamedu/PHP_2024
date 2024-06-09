<?php

declare(strict_types=1);

namespace Dsergei\Hw11;

class App
{
    public function run(): string
    {

        $client = new ElasticsearchClient(new ElasticsearchConfig());

        $query = new ElasticSearchQuery(
            new ConsoleParameters(),
            $client
        );

        $response = new ElasticsearchQueryResponse($query->query());
        return $response->getResponse();
    }
}
