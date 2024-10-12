<?php

declare(strict_types=1);

namespace App\Search;

use App\Elasticsearch\Client;
use App\Exception\ClientException;

final class ClientFactory
{
    public function make(): ClientInterface
    {
        return match (getenv('SEARCH_CLIENT')) {
            'elasticsearch' => new Client(),
            default => throw new ClientException('No client specified'),
        };
    }
}
