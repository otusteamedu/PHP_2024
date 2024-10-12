<?php

declare(strict_types=1);

namespace App\Search;

interface ClientInterface
{
    public function search(Data $data): array;

    public function createIndex(string $name, array $params): void;

    public function bulk(array $payload): void;
}