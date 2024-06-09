<?php

declare(strict_types=1);

namespace Dsergei\Hw11;

readonly class ElasticsearchConfig
{
    public string $host;

    public function __construct()
    {
        $host = getenv('ELASTICSEARCH_HOST');

        if ($host === false) {
            throw new \DomainException('ELASTICSEARCH_HOST is not defined');
        }

        $this->host = $host;
    }
}
