<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Elasticsearch;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class ElasticsearchClientFactory
{
    /**
     * @param string $host
     * @return ElasticsearchClient
     * @throws AuthenticationException
     */
    public function createWithNoAuthentication(string $host): ElasticsearchClient
    {
        $client = ClientBuilder::create()
            ->setHosts([$host])
            ->setSSLVerification(false)
            ->build();
        return new ElasticsearchClient($client);
    }

    /**
     * @param string $host
     * @param string $username
     * @param string $password
     * @return ElasticsearchClient
     * @throws AuthenticationException
     */
    public function createWithBasicAuthentication(
        string $host,
        string $username,
        string $password
    ): ElasticsearchClient {
        $client = ClientBuilder::create()
            ->setHosts([$host])
            ->setBasicAuthentication($username, $password)
            ->setSSLVerification(false)
            ->build();
        return new ElasticsearchClient($client);
    }

    /**
     * @param string $host
     * @param string $crtFilePath
     * @return ElasticsearchClient
     * @throws AuthenticationException
     */
    public function createWithCertificateAuthentication(string $host, string $crtFilePath): ElasticsearchClient
    {
        $client = ClientBuilder::create()
            ->setHosts([$host])
            ->setCABundle($crtFilePath)
            ->build();
        return new ElasticsearchClient($client);
    }
}
