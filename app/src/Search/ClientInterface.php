<?php

declare(strict_types=1);

namespace App\Search;

use App\Exception\ClientException;

interface ClientInterface
{
    /**
     * @throws ClientException
     */
    public function search(Data $data): array;

    /**
     * @throws ClientException
     */
    public function createIndex(string $name, array $params): void;

    /**
     * @throws ClientException
     */
    public function bulk(array $payload): void;
}
