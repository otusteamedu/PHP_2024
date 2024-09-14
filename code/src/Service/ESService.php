<?php

declare(strict_types=1);

namespace IraYu\Hw11\Service;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ESService
{
    public function __construct(
        protected string $esHost,
        protected string $esPassword,
    ) {
    }

    public function createClient(): Client
    {
        return ClientBuilder::create()
            ->setHosts(["{$this->esHost}/"])
            ->setBasicAuthentication('elastic', $this->esPassword)
            ->setSSLVerification(false)
            ->build()
        ;
    }
}
