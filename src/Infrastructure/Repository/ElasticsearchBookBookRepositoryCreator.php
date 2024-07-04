<?php

namespace App\Infrastructure\Repository;

use App\Domain\Repository\BookRepositoryInterface;
use App\Infrastructure\Repository\BookRepositoryCreatorInterface;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchBookBookRepositoryCreator implements BookRepositoryCreatorInterface
{
    public function createRepository($config): BookRepositoryInterface
    {

        if (!isset($config['elasticsearchHost'])) {
            throw new \InvalidArgumentException('elasticsearchHost configuration not set');
        }
        if (!isset($config['elasticsearchIndex'])) {
            throw new \InvalidArgumentException('Elasticsearch elasticsearchIndex not set');
        }

        $client = ClientBuilder::create()
            ->setHosts($config['elasticsearchHost'])
            ->build();
        $queryBuilder = new ElasticsearchBookQueryBuilder($config['elasticsearchIndex']);
        $bookDataMapper = new BookDataMapper();

        return new ElasticsearchBookRepository($client, $queryBuilder, $bookDataMapper);
    }
}
