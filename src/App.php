<?php

declare(strict_types=1);

namespace Tory495\Elasticsearch;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Dotenv\Dotenv;
class App
{
    /**
     * Application run method
     * @return void
     */
    public function run(): void
    {
        $searchService = new SearchService();
        $client = $searchService->createClient();
        $response = $client->info();
        echo (string) $response->getBody();
    }
}