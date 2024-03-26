<?php

declare(strict_types=1);

namespace Lrazumov\Hw14;

use Elastic\Elasticsearch\ClientBuilder;

class Elastic
{
    private array $query;

    public function __construct(array $query)
    {
        $this->query = $query;
    }

    public function search(): array
    {
        $client = ClientBuilder::create()
            ->setHosts([
                getenv("ELASTIC_HOST")
            ])
            ->build();
        $result = $client->search([
            'index' => 'otus-shop',
            'body' => $this->query
        ]);
        return $result->hits->hits;
    }
}
