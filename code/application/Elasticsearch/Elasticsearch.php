<?php
declare(strict_types=1);

namespace App\ElasticSearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class Elasticsearch
{

    private function clientInit() {
        try {
            return ClientBuilder::create()
                ->setHosts([getenv("ELASTICSEARCH_HOST")])
                ->build();
        } catch (AuthenticationException $e) {
            echo $e->getMessage();
        }
    }

    public function search(array $request)
    {
        $client = $this->clientInit();
        $response = $client->search($request);
        return $response['hits']['hits'];
    }
}