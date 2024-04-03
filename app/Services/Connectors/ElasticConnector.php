<?php

declare(strict_types=1);

namespace App\Services\Connectors;

use App\Contracts\ConnectorInterface;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Exception;
use Http\Promise\Promise;

class ElasticConnector implements ConnectorInterface
{
    public Client $client;
    private string $index;


    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */public function __construct(array $params)
    {
        $this->index = 'events';
        $connectHost = $params['host'] . ':' . $params['port'];

        $this->client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts([$connectHost]) // https!
            ->setBasicAuthentication('elastic', $params['password']) // Пароль
            ->build();


        if (!$this->client->indices()->exists(['index' => $this->index])->asBool()) {
            $this->client->indices()->create(['index' => $this->index])->asBool();
        }
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function setKey(string $key, mixed $value): Elasticsearch|Promise
    {
        $params = [
            'index' => $this->index,
            'id'    => $key,
            'body'  => [...$value]
        ];

        return $this->client->index($params);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function dropKey(string $key): bool
    {
        return $this->client->indices()->delete(['index' => $this->index, 'id' => $key])->asBool();
    }

    /**
     * @throws Exception
     */
    public function search(string $key): mixed
    {
        $result = $this->client->get([
            'index' => $this->index,
            'id'    => $key
        ])->asObject();

        if (empty($result->_source)) {
            return null;
        }

        return $result->_source;
    }

    /**
     * @throws Exception
     */
    public function getAll(): ?array
    {
        $result = $this->client->search([
            'index' => $this->index,
            'query' => [
                'bool' => [
                    'filter' => [
                        'gte' => [ 'id' => 0 ]
                        ]
                    ]
                ]
        ])->asArray();

        if (empty($result['hits'])) {
            return null;
        }

        return array_map(fn($result) => $result['_source'] ?? [], $result['hits']['hits']);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function update(string $key, mixed $value): bool
    {
        return $this->client->update([
            'index' => $this->index,
            'id' => $key,
            'body'  => [...$value]
        ])->asBool();
    }

    public function clear(): bool
    {
        return $this->client->indices()->delete(['index' => $this->index])->asBool();
    }
}
