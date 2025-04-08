<?php

declare(strict_types=1);

namespace Valen\App\Infrastructure\OpenSearch;

use OpenSearch\Client;
use OpenSearch\SymfonyClientFactory;

class OpenSearchClient
{
    public ?Client $client;

    public function __construct()
    {
        // Simple Setup
        $this->client = (new SymfonyClientFactory())->create([
            'base_uri' => 'https://opensearch:9200/',
            'auth_basic' => ['admin', getenv('OPENSEARCH_INITIAL_ADMIN_PASSWORD')],
            'verify_peer' => false, // Disables SSL verification for local development.
            'verify_host' => false,
        ]);
    }
}
