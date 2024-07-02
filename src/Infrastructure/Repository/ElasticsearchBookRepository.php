<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\BookCollection;
use App\Domain\Repository\BookRepositoryInterface;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client;
use App\Infrastructure\Repository\BookDataMapper;

class ElasticsearchBookRepository implements BookRepositoryInterface
{
    private ElasticsearchBookQueryBuilder $queryBuilder;
    private BookDataMapper $bookDataMapper;
    private Client $client;

    public function __construct(array $host, string $index)
    {
        $this->bookDataMapper = new BookDataMapper();
        $this->queryBuilder = new ElasticsearchBookQueryBuilder($index);
        $this->client = ClientBuilder::create()
            ->setHosts($host)
            ->build();
    }

    public function search(
        ?string $title,
        ?string $category,
        ?int $minPrice,
        ?int $maxPrice,
        ?string $shopName,
        ?int $minStock): BookCollection
    {
        $queryParams = $this->queryBuilder
            ->setTitle($title)
            ->setCategory($category)
            ->setMinPrice($minPrice)
            ->setMaxPrice($maxPrice)
            ->setShopName($shopName)
            ->setMinStock($minStock)
            ->build()
            ->getQuery();

        $response = $this->client->search($queryParams)->asArray();

        $bookCollection = new BookCollection();
        foreach ($response['hits']['hits'] as $hit) {
            $bookCollection->add($this->bookDataMapper->map($hit['_source']));
        }

        return $bookCollection;
    }
}
