<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Repositories\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

abstract class AbstractElasticRepository
{
    abstract protected function getIndexName(): string;
    abstract protected function getCreateSettingsParams(): ?array;
    abstract protected function getCreateMappingsParams(): ?array;

    protected array $searchParams = [];

    private Client $elasticClient;

    public function __construct(Client $client)
    {
        $this->elasticClient = $client;
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function removeIndex(): void
    {
        $this->elasticClient->indices()->delete([
            'index' => $this->getIndexName()
        ]);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function createIndex(): void
    {
        $params['index'] = $this->getIndexName();

        $settings = $this->getCreateSettingsParams();

        if ($settings !== null) {
            $params['body']['settings'] = $settings;
        }

        $mappings = $this->getCreateMappingsParams();

        if ($mappings !== null) {
            $params['body']['mappings'] = $mappings;
        }

        $this->elasticClient->indices()->create($params);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(): Elasticsearch|Promise
    {
        return $this->elasticClient->search([
            'index' => $this->getIndexName(),
            'body' => $this->searchParams
        ]);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function bulk(array $data): void
    {
        $this->elasticClient->bulk(['body' => $data]);
    }
}
