<?php

namespace Aware\App\Infrastructure\Mongo;

use MongoDB\Client;
use MongoDB\Collection;

class MongoClient
{
    public Collection $collection;

    public function __construct(
        string $uri,
        string $database,
        string $collection
    ) {
        $client = new Client($uri);
        $this->collection = $client->selectDatabase($database)->selectCollection($collection);
    }

    public function save($data): string
    {
        $result = $this->collection->insertOne($data);
        return (string)$result->getInsertedId();
    }
}
