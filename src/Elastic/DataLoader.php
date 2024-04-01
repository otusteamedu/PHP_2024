<?php

declare(strict_types=1);

namespace Pozys\OtusShop\Elastic;

use Elastic\Elasticsearch\Client;

class DataLoader
{
    private Client $client;

    public function __construct(private Connection $connection)
    {
        $this->client = $this->connection->getClient();
    }

    public function index(array $data): bool
    {
        return $this->client->bulk($data)->asBool();
    }
}
