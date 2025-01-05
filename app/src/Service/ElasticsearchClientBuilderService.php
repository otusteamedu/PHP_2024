<?php

declare(strict_types=1);

namespace App\Service;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchClientBuilderService
{
    public function __construct(
        private readonly string $host,
        private readonly string $login,
        private readonly string $pwd)
    {
    }

    public function build(): Client
    {
        return ClientBuilder::create()
            ->setHosts([$this->host])
            ->setBasicAuthentication($this->login, $this->pwd)
            ->setSSLVerification(false)
            ->build();
    }
}
