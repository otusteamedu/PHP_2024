<?php

declare(strict_types=1);

namespace Valen\App\Infrastructure\OpenSearch;

use OpenSearch\Client;
use OpenSearch\SymfonyClientFactory;

class OpenSearchClient
{
    protected ?Client $client;

    public function __construct()
    {
        // Simple Setup
        $this->client = (new SymfonyClientFactory())->create([
            'base_uri' => 'https://localhost:9200',
            'auth' => ['admin', getenv('OPENSEARCH_INITIAL_ADMIN_PASSWORD')],
            'verify' => false, // Disables SSL verification for local development.
        ]);
    }
}
