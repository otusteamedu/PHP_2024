<?php

namespace AleksandrOrlov\Php2024;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use RuntimeException;

class Elastic
{
    private Client $client;

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @throws AuthenticationException
     */
    public function __construct(
        private readonly string $host,
        private readonly string $user,
        private readonly string $password,
    ) {
        $this->connect();
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @throws AuthenticationException
     */
    private function connect(): void
    {
        $client = ClientBuilder::create()
            ->setHosts([$this->host])
            ->setSSLVerification(false)
            ->setBasicAuthentication($this->user, $this->password)
            ->build();

        $this->client = $client;
    }

    /**
     * Наполнение индекса данными из файла
     */
    public function bulk(string $filePath, string $indexName): void
    {
        try {
            $this->client->bulk([
                'index' => $indexName,
                'body'  => file_get_contents($filePath),
            ]);
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
