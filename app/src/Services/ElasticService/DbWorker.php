<?php

declare(strict_types=1);

namespace App\Services\ElasticService;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class DbWorker
{
    public Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function isIndex(string $index): bool
    {
        $params = [
            'index' => $index
        ];
        return $this->client->indices()->exists($params)->asBool();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function createIndex(string $index): bool
    {
        $params = [
            'index' => $index,
            'body' => [
                'settings' => [
                    'analysis' => [
                        'filter' => [
                            'ru_stop' => [
                                'type' => 'stop',
                                'stopwords' => '_russian_',
                            ],
                            'ru_stemmer' => [
                                'type' => 'stemmer',
                                'language' => 'russian',
                            ],
                        ],
                        'analyzer' => [
                            'my_russian' => [
                                'tokenizer' => 'standard',
                                'filter' => [
                                    'lowercase',
                                    'ru_stop',
                                    'ru_stemmer'
                                ]
                            ]
                        ]
                    ],
                ],
            ]
        ];
        return $this->client->indices()->create($params)->asBool();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function indexNewDoc(string $index, array $values): bool
    {
        $params = [
            'index' => $index,
            'body'  => [
                ...$values
            ],
        ];
        return $this->client->index($params)->asBool();

    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function getDocbyId(string $index, string $id): object
    {
        $params = [
            'index' => $index,
            'id'    => $id,
        ];

        return $this->client->get($params)->asObject();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function getDocbyParams(string $index, array $params): array
    {
        $params = [
            'index' => $index,
            'scroll' => '5m',
            'size' => 100,
            'body'  => [
                'query' => [
                    ...$params
                ]
            ]
        ];
        return $this->client->search($params)->asArray();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function updateDoc(string $index, string $id, array $values): bool
    {
        $params = [
            'index' => $index,
            'id'    => $id,
            'body'  => [
                'doc' => [
                    ...$values
                ]
            ]
        ];

        return $this->client->update($params)->asBool();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function deleteDoc(string $index, string $id): bool
    {
        $params = [
            'index' => $index,
            'id'    => $id,
        ];

        return $this->client->delete($params)->asBool();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function deleteIndex(string $index): bool
    {
        $param = [
            'index' => $index,
        ];
        return $this->client->indices()->delete($param)->asBool();
    }

    public function bulk(string $data): void
    {
        exec(
            "curl \
            --request POST 'http://localhost:9200/_bulk' \
            --header 'Content-Type: application/json' \
            --data-binary '@{$data}'"
        );
    }
}
