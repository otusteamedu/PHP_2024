<?php

declare(strict_types=1);

namespace App\Shared\Search;

interface SearchClientInterface
{
    public function search(string $indexName, ?SearchCriteria $searchCriteria = null): array;

    public function createIndex(string $name, array $schema = []): void;

    public function deleteIndex(string $name): void;

    public function bulk(string $indexName, array $data): void;
}
