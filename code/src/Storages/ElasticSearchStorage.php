<?php

namespace Naimushina\ElasticSearch\Storages;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Elastic\Transport\Exception\NoNodeAvailableException;
use Exception;
use Http\Promise\Promise;
use Naimushina\ElasticSearch\Repositories\ElasticSearchRepository;
use Naimushina\ElasticSearch\Repositories\RepositoryInterface;

class ElasticSearchStorage implements StorageInterface
{
    /**
     * @var Client
     */
    private Client $client;
    /**
     * @var string
     */
    public mixed $indexName;

    /**
     * @param string $host
     * @param string $index
     * @param array $mappings
     * @param array $settings
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws NoNodeAvailableException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function __construct(
        string $host,
        string $index,
        array $mappings = [],
        array $settings = []
    ) {
        $this->setClient($host);
        $this->indexName = $index;
        $params['body'] = [
            'mappings' => $mappings,
            'settings' => $settings
        ];
        if (!$this->checkIfIndexExists()) {
            $this->createIndex($index, $params);
        }
    }

    /**
     * @param string $name
     * @param array $params
     * @return Elasticsearch|Promise
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException|NoNodeAvailableException
     */
    public function createIndex(string $name, array $params = []): Elasticsearch|Promise
    {
        $params = [
            'index' => $this->indexName,
            ...$params
        ];
        return $this->client->indices()->create($params);
    }

    /**
     * @return bool
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function clear(): bool
    {
        return !!$this->client->indices()->delete(['index' => $this->indexName]);
    }

    /**
     * @param RepositoryInterface $repository
     * @param array $params
     * @return array
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(RepositoryInterface $repository, array $params): array
    {
        $body = $repository->formatSearchParams($params);
        $request = [
            'index' => $this->indexName,
            'body' => $body
        ];

        $response = $this->client->search($request);
        return $this->getItemsFromResponse($response);
    }

    /**
     * @param string $host
     * @return void
     * @throws AuthenticationException
     * @throws Exception
     */
    private function setClient(string $host): void
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$host])
            ->setBasicAuthentication('username', 'password')
            ->setSSLVerification(false)
            ->build();

        try {
            $this->client->info();
        } catch (Exception $e) {
            throw new Exception("Проблема подключения к ElasticSearch: %s", $e->getMessage());
        }
    }

    /**
     * @param string $fullPath
     * @return array
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws Exception
     */
    public function seedFromFile(string $fullPath): array
    {
        $content = file_get_contents($fullPath);
        if ($content) {
            $params = [
                'index' => $this->indexName,
                'body' => $content,
            ];
            $result = $this->client->bulk($params);
            return $result->asArray();
        } else {
            throw new Exception("Нет данных для загрузки в файле $fullPath");
        }
    }

    /**
     * @throws ClientResponseException
     * @throws NoNodeAvailableException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function checkIfIndexExists(): bool
    {
        $params = ['index' => $this->indexName];
        $result = $this->client->indices()->exists($params)->getStatusCode();
        return $result === 200;
    }

    /**
     * @param Elasticsearch|Promise $response
     * @return array
     */
    private function getItemsFromResponse(Elasticsearch|Promise $response): array
    {
        $allHits = $response->asArray()['hits']['hits'] ?? [];
        return array_column($allHits, '_source');
    }
}
