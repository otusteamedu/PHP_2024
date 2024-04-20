<?php

declare(strict_types=1);

namespace AShutov\Hw14;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Helper\Iterators\SearchHitIterator;
use Elastic\Elasticsearch\Helper\Iterators\SearchResponseIterator;
use Exception;

class ElasticHandler
{
    public Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct(public readonly Config $config)
    {
        $this->client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts([$config->elasticHost])
            ->setBasicAuthentication($this->config->elasticUser, $this->config->elasticPassword)
            ->build();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function createIndex(string $index, bool $needRecreate): bool
    {
        if (!$needRecreate && $this->isIndexExists($index)) {
            return true;
        }

        if ($needRecreate && $this->isIndexExists($index)) {
            $this->dropIndex($index);
        }

        $params = [
            'index' => $index,
            'body' => [
                ...$this->config->indexSettings
            ]
        ];

        return $this->client->indices()->create($params)->asBool();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    private function isIndexExists(string $index): bool
    {
        return $this->client->indices()->exists(['index' => $index])->asBool();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function bulk(string $dataPath): void
    {
        $data = file_get_contents($dataPath);

        $this->client->bulk([
            'index' => $this->config->elasticIndex,
            'body' => $data,
        ]);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function dropIndex(string $index): bool
    {
        return $this->client->indices()->delete(['index' => $index])->asBool();
    }

    /**
     * @throws Exception
     */
    public function search(array $query): SearchHitIterator
    {
        $pages = new SearchResponseIterator($this->client, $query);

        return new SearchHitIterator($pages);
    }
}
