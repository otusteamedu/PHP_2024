<?php
declare(strict_types=1);

namespace App\ElasticSearch;


use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class Elasticsearch
{
    private Client $client;
    const HOST = 'elasticsearch:9200';

    public function __construct() {
        try {
            $this->client = ClientBuilder::create()
                ->setHosts([self::HOST])
                ->build();
        } catch (AuthenticationException $e) {
            echo $e->getMessage();
        }
    }

    public function search(array $params): array
    {
        return $params;
    }

}