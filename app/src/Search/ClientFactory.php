<?php

declare(strict_types=1);

namespace App\Search;

use App\Elasticsearch\Client;

final class ClientFactory
{
    public function make(): ClientInterface
    {
        return new Client();
    }
}