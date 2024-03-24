<?php

declare(strict_types=1);

namespace Lrazumov\Hw14;

class Elastic
{
    private array $query;

    public function __construct(array $query)
    {
        $this->query = $query;
    }

    public function search(): array
    {
        $client = new \Elasticsearch\Client();
        $result = $client->search([
            'index' => 'products',
            'body' => $this->query
        ]);
        return $result['hits']['hits'];
    }
}
