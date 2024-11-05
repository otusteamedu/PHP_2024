<?php

namespace Komarov\Hw12\Service;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;

class ElasticService
{
    private Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()->setHosts(['localhost:9200'])->build();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function searchProducts(array $criteria): Elasticsearch
    {
        $must = [];

        foreach ($criteria as $field => $value) {
            $must[] = [
                'match' => [
                    $field => $value
                ]
            ];
        }

        $params = [
            'index' => 'otus-shop',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => $must
                    ]
                ]
            ]
        ];

        return $this->client->search($params);
    }
}
