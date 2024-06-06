<?php

declare(strict_types=1);

namespace JuliaZhigareva\ElasticProject;

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

readonly class SearchService
{
    public function __construct(private ElasticClient $client, private Query $query)
    {
    }

    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(Arguments $arguments): Elasticsearch|Promise
    {
        $elasticClient = $this->client->getClient();
        $query = $this->query->get(
            new QueryParams($arguments->searchQuery, $arguments->category, $arguments->maxPrice, $arguments->minPrice)
        );
        return $elasticClient->search(['index' => $arguments->index, 'body' => $query]);
    }
}
