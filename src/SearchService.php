<?php

declare(strict_types=1);

namespace Tory495\Elasticsearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class SearchService
{
    /**
     * Method, which create and return elastic client
     * @return Client|null
     */
    public function createClient(): ?Client
    {
        try {
            return ClientBuilder::create()
                ->setHosts(["https://{$_ENV['ELASTIC_HOST']}:{$_ENV['ELASTIC_PORT']}/"])
                ->setApiKey($_ENV['ELASTIC_API_KEY'])
                ->setCABundle('http_ca.crt')
                ->build();
        } catch (AuthenticationException $e) {
            echo $e->getMessage() . PHP_EOL;
        }

        return null;
    }
}
