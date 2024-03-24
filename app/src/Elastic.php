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
            ->setHosts(['http://84.38.181.159:5555/'])
            // ->setApiKey('<api-key>')
            ->build();
        return $client->search([
            'index' => 'otus-test',
            'body' => $this->query
        ]);
    }
}
