<?php

declare(strict_types=1);

namespace Dsergei\Hw11;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchClient
{
    public function __construct(
        private ElasticsearchConfig $config
    ) {
    }

    public function buildClient()
    {
        return ClientBuilder::create()
            ->setHosts([$this->config->host])
            ->setSSLVerification(false)
            ->build();
    }
}
