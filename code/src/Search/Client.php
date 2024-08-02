<?php

declare(strict_types=1);

namespace Viking311\Books\Search;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class Client
{
    private \Elastic\Elasticsearch\Client $elasticClient;
    private QueryBuilder $queryBuilder;
    public function __construct(\Elastic\Elasticsearch\Client $elasticClient, QueryBuilder $queryBuilder)
    {
        $this->elasticClient = $elasticClient;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param array $options
     * @return array
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(array $options): array
    {
        $result = $this->elasticClient->search($this->queryBuilder->createRequest($options));
        return $result['hits']['hits'];
    }
}
