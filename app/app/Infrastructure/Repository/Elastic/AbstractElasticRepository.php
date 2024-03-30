<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Infrastructure\Repository\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

abstract readonly class AbstractElasticRepository
{
    protected Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct(
        private string $host,
        private int $port,
    ) {
        $this->client = ClientBuilder::create()->setHosts(["$this->host:$this->port"])->build();
    }
}
