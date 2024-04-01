<?php

declare(strict_types=1);

namespace Pozys\OtusShop\Elastic;

use Elastic\Elasticsearch\Client;

class IndexManager
{
    private Client $client;
    private array $request = [];

    public function __construct(
        private Connection $connection
    ) {
        $this->client = $this->connection->getClient();
    }

    public function indexExists(string $index): bool
    {
        return $this->client->indices()->exists(compact('index'))->asBool();
    }

    public function createIndex(string $index): void
    {
        $baseRequest = RequestBuilder::baseRequest($index);
        $this->addMappings($this->getMapping());
        $this->setDefaultAnalyzer();

        $this->request = RequestBuilder::setBody($baseRequest, $this->getRequest());

        $this->client->indices()->create($this->getRequest());
    }

    public function buildIndexRequest(array $data): array
    {
        return RequestBuilder::setBody([], $data);
    }

    private function addMappings(array $mapping): void
    {
        $this->request['mappings'] = $mapping;
    }

    private function setSettings(array $settings): void
    {
        $this->request['settings'] = $settings;
    }

    private function getMapping(): array
    {
        return [
            'properties' => [
                'category' => [
                    'type' => 'keyword',
                    'normalizer' => 'lowercase'
                ],
                'price' => [
                    'type' => 'float'
                ],
                'sku' => [
                    'type' => 'keyword',
                ],
                'stock' => [
                    'type' => 'nested',
                    'properties' => [
                        'shop' => [
                            'type' => 'text',
                        ],
                        'stock' => [
                            'type' => 'short'
                        ]
                    ]
                ],
                'title' => [
                    'type' => 'text',
                ]
            ]
        ];
    }

    private function setDefaultAnalyzer(): void
    {
        $this->setSettings([
            'analysis' => [
                'analyzer' => [
                    'default' => [
                        'type' => 'russian',
                    ]
                ]
            ]
        ]);
    }

    private function getRequest(): array
    {
        return $this->request;
    }
}
