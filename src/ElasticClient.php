<?php

declare(strict_types=1);

namespace JuliaZhigareva\ElasticProject;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

readonly class ElasticClient
{
    public function __construct(private ElasticConfig $config)
    {}

    /**
     * @throws AuthenticationException
     */
    public function getClient(): Client
    {
        return ClientBuilder::create()
            ->setHosts([$this->config->host])
            ->setSSLVerification($this->config->sslVerification)
            ->setBasicAuthentication($this->config->username, $this->config->password)
            ->build();
    }

}